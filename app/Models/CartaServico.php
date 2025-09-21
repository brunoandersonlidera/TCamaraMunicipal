<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartaServico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'carta_servicos';

    protected $fillable = [
        'codigo_servico',
        'nome_servico',
        'descricao',
        'categoria',
        'base_legal',
        'requisitos',
        'documentos_necessarios',
        'prazo_atendimento_dias',
        'custo',
        'forma_prestacao',
        'canais_atendimento',
        'horario_funcionamento',
        'endereco_atendimento',
        'telefone_contato',
        'email_contato',
        'orgao_responsavel',
        'setor_responsavel',
        'responsavel_tecnico',
        'responsavel_aprovacao',
        'compromissos_qualidade',
        'mecanismos_comunicacao',
        'procedimentos_reclamacao',
        'outras_informacoes',
        'legislacao_aplicavel',
        'versao',
        'data_vigencia',
        'data_revisao',
        'ativo',
        'publicado',
        'criado_por',
        'atualizado_por'
    ];

    protected $casts = [
        'documentos_necessarios' => 'array',
        'canais_atendimento' => 'array',
        'prazo_atendimento_dias' => 'integer',
        'custo' => 'decimal:2',
        'ativo' => 'boolean',
        'publicado' => 'boolean',
        'data_vigencia' => 'date',
        'data_revisao' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Enums
    const PRAZO_UNIDADES = [
        'horas' => 'Horas',
        'dias' => 'Dias',
        'dias_uteis' => 'Dias Úteis',
        'semanas' => 'Semanas',
        'meses' => 'Meses'
    ];

    const CANAIS_PADRAO = [
        'presencial' => 'Atendimento Presencial',
        'telefone' => 'Telefone',
        'email' => 'E-mail',
        'site' => 'Site da Câmara',
        'esic' => 'Sistema E-SIC',
        'ouvidoria' => 'Ouvidoria'
    ];

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem_exibicao')->orderBy('nome');
    }

    public function scopeGratuitos($query)
    {
        return $query->where('custo', 0);
    }

    public function scopePagos($query)
    {
        return $query->where('custo', '>', 0);
    }

    public function scopePorSetor($query, $setor)
    {
        return $query->where('responsavel_setor', $setor);
    }

    public function scopeBuscar($query, $termo)
    {
        return $query->where(function ($q) use ($termo) {
            $q->where('nome', 'like', "%{$termo}%")
              ->orWhere('descricao', 'like', "%{$termo}%")
              ->orWhere('publico_alvo', 'like', "%{$termo}%")
              ->orWhere('responsavel_setor', 'like', "%{$termo}%");
        });
    }

    // Accessors
    public function getPrazoFormatadoAttribute()
    {
        if (!$this->prazo_atendimento) {
            return 'Não informado';
        }

        $unidade = self::PRAZO_UNIDADES[$this->prazo_unidade] ?? $this->prazo_unidade;
        return $this->prazo_atendimento . ' ' . strtolower($unidade);
    }

    public function getCustoFormatadoAttribute()
    {
        if ($this->custo == 0) {
            return 'Gratuito';
        }
        return 'R$ ' . number_format($this->custo, 2, ',', '.');
    }

    public function getCanaisFormatadosAttribute()
    {
        if (!$this->canais_atendimento) {
            return [];
        }

        return collect($this->canais_atendimento)->map(function ($canal) {
            return self::CANAIS_PADRAO[$canal] ?? $canal;
        })->toArray();
    }

    public function getDocumentosListaAttribute()
    {
        if (!$this->documentos_necessarios) {
            return 'Nenhum documento necessário';
        }

        return collect($this->documentos_necessarios)->implode('; ');
    }

    public function getEtapasListaAttribute()
    {
        if (!$this->etapas_processo) {
            return [];
        }

        return collect($this->etapas_processo)->map(function ($etapa, $index) {
            return ($index + 1) . '. ' . $etapa;
        })->toArray();
    }

    public function getTemCustoAttribute()
    {
        return $this->custo > 0;
    }

    public function getEGratuitoAttribute()
    {
        return $this->custo == 0;
    }

    // Mutators
    public function setDocumentosNecessariosAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['documentos_necessarios'] = json_encode(
                array_filter(array_map('trim', explode("\n", $value)))
            );
        } else {
            $this->attributes['documentos_necessarios'] = json_encode($value);
        }
    }

    public function setEtapasProcessoAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['etapas_processo'] = json_encode(
                array_filter(array_map('trim', explode("\n", $value)))
            );
        } else {
            $this->attributes['etapas_processo'] = json_encode($value);
        }
    }

    public function setCanaisAtendimentoAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['canais_atendimento'] = json_encode(
                array_filter(array_map('trim', explode(',', $value)))
            );
        } else {
            $this->attributes['canais_atendimento'] = json_encode($value);
        }
    }

    // Métodos auxiliares
    public function ativar()
    {
        $this->ativo = true;
        return $this->save();
    }

    public function desativar()
    {
        $this->ativo = false;
        return $this->save();
    }

    public function proximaOrdem()
    {
        return self::max('ordem_exibicao') + 1;
    }

    public function moverPara($novaOrdem)
    {
        $ordemAtual = $this->ordem_exibicao;
        
        if ($novaOrdem > $ordemAtual) {
            // Movendo para baixo
            self::whereBetween('ordem_exibicao', [$ordemAtual + 1, $novaOrdem])
                ->decrement('ordem_exibicao');
        } else {
            // Movendo para cima
            self::whereBetween('ordem_exibicao', [$novaOrdem, $ordemAtual - 1])
                ->increment('ordem_exibicao');
        }

        $this->ordem_exibicao = $novaOrdem;
        return $this->save();
    }

    public function duplicar()
    {
        $novo = $this->replicate();
        $novo->nome = $this->nome . ' (Cópia)';
        $novo->ativo = false;
        $novo->ordem_exibicao = $this->proximaOrdem();
        $novo->save();

        return $novo;
    }

    // Métodos estáticos
    public static function reordenar()
    {
        $servicos = self::orderBy('ordem_exibicao')->get();
        
        foreach ($servicos as $index => $servico) {
            $servico->update(['ordem_exibicao' => $index + 1]);
        }
    }

    public static function estatisticas()
    {
        return [
            'total' => self::count(),
            'ativos' => self::where('ativo', true)->count(),
            'inativos' => self::where('ativo', false)->count(),
            'gratuitos' => self::where('custo', 0)->count(),
            'pagos' => self::where('custo', '>', 0)->count(),
            'setores' => self::distinct('responsavel_setor')->count('responsavel_setor')
        ];
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($servico) {
            if (!$servico->ordem_exibicao) {
                $servico->ordem_exibicao = $servico->proximaOrdem();
            }
        });
    }
}
