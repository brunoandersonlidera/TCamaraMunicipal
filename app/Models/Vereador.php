<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Vereador extends Model
{
    use HasFactory;

    protected $table = 'vereadores';

    protected $fillable = [
        'nome',
        'nome_parlamentar',
        'partido',
        'email',
        'telefone',
        'foto',
        'biografia',
        'data_nascimento',
        'profissao',
        'escolaridade',
        'endereco',
        'redes_sociais',
        'status',
        'inicio_mandato',
        'fim_mandato',
        'legislatura',
        'comissoes',
        'projetos_apresentados',
        'votos_favoraveis',
        'votos_contrarios',
        'abstencoes',
        'presencas_sessoes',
        'observacoes'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'inicio_mandato' => 'date',
        'fim_mandato' => 'date',
        'redes_sociais' => 'array',
        'comissoes' => 'array',
        'projetos_apresentados' => 'integer',
        'votos_favoraveis' => 'integer',
        'votos_contrarios' => 'integer',
        'abstencoes' => 'integer',
        'presencas_sessoes' => 'integer'
    ];

    protected $dates = [
        'data_nascimento',
        'inicio_mandato',
        'fim_mandato',
        'deleted_at'
    ];

    // Relacionamentos
    public function projetosLei()
    {
        return $this->hasMany(ProjetoLei::class, 'autor_id');
    }

    public function noticias()
    {
        return $this->hasMany(Noticia::class, 'autor_id');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'usuario_upload_id');
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    public function scopeInativos($query)
    {
        return $query->where('status', 'inativo');
    }

    public function scopeLegislatura($query, $legislatura)
    {
        return $query->where('legislatura', $legislatura);
    }

    public function scopePartido($query, $partido)
    {
        return $query->where('partido', $partido);
    }

    // Accessors
    protected function nomeCompleto(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->nome_parlamentar ?: $this->nome,
        );
    }

    protected function idade(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_nascimento ? $this->data_nascimento->age : null,
        );
    }

    protected function mandatoAtivo(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === 'ativo' && 
                         $this->inicio_mandato <= now() && 
                         $this->fim_mandato >= now(),
        );
    }

    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->foto ? asset('files/' . $this->foto) : asset('images/vereador-placeholder.jpg'),
        );
    }

    // Métodos auxiliares
    public function getTotalVotos()
    {
        return $this->votos_favoraveis + $this->votos_contrarios + $this->abstencoes;
    }

    public function getPercentualPresenca()
    {
        if (!$this->presencas_sessoes) return 0;
        
        // Aqui você pode implementar a lógica para calcular o percentual
        // baseado no total de sessões da legislatura
        return round(($this->presencas_sessoes / 100) * 100, 2); // Exemplo
    }

    public function isAtivo()
    {
        return $this->status === 'ativo';
    }

    public function isPresidente()
    {
        $comissoes = $this->comissoes ?? [];
        if (is_string($comissoes)) {
            $comissoes = json_decode($comissoes, true) ?? [];
        }
        return in_array('presidente', $comissoes);
    }

    public function isVicePresidente()
    {
        $comissoes = $this->comissoes ?? [];
        if (is_string($comissoes)) {
            $comissoes = json_decode($comissoes, true) ?? [];
        }
        return in_array('vice-presidente', $comissoes);
    }

    // Validações customizadas
    public static function rules($id = null)
    {
        return [
            'nome' => 'required|string|max:255',
            'nome_parlamentar' => 'nullable|string|max:255',
            'partido' => 'required|string|max:10',
            'email' => 'required|email|unique:vereadores,email,' . $id,
            'telefone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'biografia' => 'nullable|string',
            'data_nascimento' => 'nullable|date|before:today',
            'profissao' => 'nullable|string|max:255',
            'escolaridade' => 'nullable|in:fundamental,medio,superior,pos-graduacao,mestrado,doutorado',
            'endereco' => 'nullable|string',
            'status' => 'required|in:ativo,inativo,licenciado,afastado',
            'inicio_mandato' => 'required|date',
            'fim_mandato' => 'required|date|after:inicio_mandato',
            'legislatura' => 'required|string|max:20',
            'projetos_apresentados' => 'nullable|integer|min:0',
            'votos_favoraveis' => 'nullable|integer|min:0',
            'votos_contrarios' => 'nullable|integer|min:0',
            'abstencoes' => 'nullable|integer|min:0',
            'presencas_sessoes' => 'nullable|integer|min:0'
        ];
    }

    public static function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'partido.required' => 'O partido é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ter um formato válido.',
            'email.unique' => 'Este e-mail já está sendo usado por outro vereador.',
            'data_nascimento.before' => 'A data de nascimento deve ser anterior a hoje.',
            'inicio_mandato.required' => 'A data de início do mandato é obrigatória.',
            'fim_mandato.required' => 'A data de fim do mandato é obrigatória.',
            'fim_mandato.after' => 'A data de fim deve ser posterior à data de início.',
            'legislatura.required' => 'A legislatura é obrigatória.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser: ativo, inativo, licenciado ou afastado.'
        ];
    }

    // Métodos de busca
    public static function search($query)
    {
        return self::where('status', 'ativo')
            ->where(function ($q) use ($query) {
                $q->where('nome', 'LIKE', "%{$query}%")
                  ->orWhere('nome_parlamentar', 'LIKE', "%{$query}%")
                  ->orWhere('partido', 'LIKE', "%{$query}%")
                  ->orWhere('profissao', 'LIKE', "%{$query}%")
                  ->orWhere('biografia', 'LIKE', "%{$query}%");
            })
            ->orderBy('nome');
    }

    public function getSearchableContent()
    {
        return [
            'nome' => $this->nome,
            'nome_parlamentar' => $this->nome_parlamentar,
            'partido' => $this->partido,
            'profissao' => $this->profissao,
            'biografia' => strip_tags($this->biografia),
        ];
    }

    public function getSearchUrl()
    {
        return route('vereadores.show', $this->id);
    }

    public function getSearchType()
    {
        return 'Vereador';
    }

    public function getSearchDate()
    {
        return $this->inicio_mandato;
    }
}
