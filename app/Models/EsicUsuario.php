<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EsicUsuario extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'esic_usuarios';

    protected $fillable = [
        'nome',
        'email',
        'password',
        'cpf',
        'rg',
        'data_nascimento',
        'telefone',
        'celular',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'ativo',
        'email_verified_at',
        'token_ativacao',
        'aceite_termos',
        'aceite_termos_em',
        'aceite_lgpd',
        'aceite_lgpd_em',
        'ultimo_acesso',
        'ip_ultimo_acesso'
    ];

    protected $hidden = [
        'password',
        'token_ativacao',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'data_nascimento' => 'date',
        'aceite_termos' => 'boolean',
        'aceite_termos_em' => 'datetime',
        'aceite_lgpd' => 'boolean',
        'aceite_lgpd_em' => 'datetime',
        'ativo' => 'boolean',
        'ultimo_acesso' => 'datetime',
        'password' => 'hashed',
    ];

    // Relacionamentos
    public function manifestacoes()
    {
        return $this->hasMany(OuvidoriaManifestacao::class, 'esic_usuario_id');
    }

    public function notificacoes()
    {
        return $this->morphMany(Notificacao::class, 'notificavel');
    }

    public function anexosEnviados()
    {
        return $this->hasMany(ManifestacaoAnexo::class, 'uploaded_by');
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeVerificados($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeComTermosAceitos($query)
    {
        return $query->where('aceite_termos', true);
    }

    // Accessors
    public function getNomeCompletoAttribute()
    {
        return $this->nome;
    }

    public function getEnderecoCompletoAttribute()
    {
        $endereco = $this->endereco;
        if ($this->numero) {
            $endereco .= ', ' . $this->numero;
        }
        if ($this->complemento) {
            $endereco .= ', ' . $this->complemento;
        }
        if ($this->bairro) {
            $endereco .= ' - ' . $this->bairro;
        }
        if ($this->cidade && $this->estado) {
            $endereco .= ' - ' . $this->cidade . '/' . $this->estado;
        }
        if ($this->cep) {
            $endereco .= ' - CEP: ' . $this->cep;
        }
        return $endereco;
    }

    public function getCpfFormatadoAttribute()
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->cpf);
    }

    public function getTelefoneFormatadoAttribute()
    {
        if (strlen($this->telefone) == 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $this->telefone);
        } elseif (strlen($this->telefone) == 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $this->telefone);
        }
        return $this->telefone;
    }

    // Mutators
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setTelefoneAttribute($value)
    {
        $this->attributes['telefone'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setCelularAttribute($value)
    {
        $this->attributes['celular'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setCepAttribute($value)
    {
        $this->attributes['cep'] = preg_replace('/[^0-9]/', '', $value);
    }

    // Métodos auxiliares
    public function isEmailVerificado()
    {
        return !is_null($this->email_verified_at);
    }

    public function isAtivo()
    {
        return $this->ativo;
    }

    public function hasAceitadoTermos()
    {
        return $this->aceite_termos;
    }

    public function hasAceitadoLgpd()
    {
        return $this->aceite_lgpd;
    }

    public function podeAcessarSistema()
    {
        return $this->isAtivo() && $this->isEmailVerificado() && $this->hasAceitadoTermos();
    }

    public function gerarTokenAtivacao()
    {
        $this->token_ativacao = bin2hex(random_bytes(32));
        $this->save();
        return $this->token_ativacao;
    }

    public function ativarConta()
    {
        $this->email_verified_at = now();
        $this->ativo = true;
        $this->token_ativacao = null;
        $this->save();
    }

    public function registrarAcesso($ip = null)
    {
        $this->ultimo_acesso = now();
        if ($ip) {
            $this->ip_ultimo_acesso = $ip;
        }
        $this->save();
    }

    public function aceitarTermos()
    {
        $this->aceite_termos = true;
        $this->aceite_termos_em = now();
        $this->save();
    }

    public function aceitarLgpd()
    {
        $this->aceite_lgpd = true;
        $this->aceite_lgpd_em = now();
        $this->save();
    }

    // Estatísticas
    public function getTotalManifestacoes()
    {
        return $this->manifestacoes()->count();
    }

    public function getManifestacoesPendentes()
    {
        return $this->manifestacoes()
            ->whereIn('status', ['nova', 'em_analise', 'em_tramitacao', 'aguardando_informacoes'])
            ->count();
    }

    public function getManifestacoesConcluidas()
    {
        return $this->manifestacoes()
            ->whereIn('status', ['respondida', 'finalizada'])
            ->count();
    }
}
