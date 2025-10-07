<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class ProjetoLei extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projetos_lei';

    // Constantes para tipos de proposições
    const TIPO_LEI_ORDINARIA = 'lei_ordinaria';
    const TIPO_LEI_COMPLEMENTAR = 'lei_complementar';
    const TIPO_EMENDA_LOM = 'emenda_lom';
    const TIPO_DECRETO_LEGISLATIVO = 'decreto_legislativo';
    const TIPO_RESOLUCAO = 'resolucao';
    const TIPO_PROJETO_RESOLUCAO = 'projeto_resolucao';
    const TIPO_INDICACAO = 'indicacao';
    const TIPO_REQUERIMENTO = 'requerimento';
    const TIPO_MOCAO = 'mocao';

    // Constantes para status de tramitação
    const STATUS_PROTOCOLADO = 'protocolado';
    const STATUS_DISTRIBUIDO = 'distribuido';
    const STATUS_EM_COMISSAO = 'em_comissao';
    const STATUS_PRONTO_PAUTA = 'pronto_pauta';
    const STATUS_EM_VOTACAO = 'em_votacao';
    const STATUS_APROVADO_1_TURNO = 'aprovado_1_turno';
    const STATUS_APROVADO_2_TURNO = 'aprovado_2_turno';
    const STATUS_APROVADO = 'aprovado';
    const STATUS_REJEITADO = 'rejeitado';
    const STATUS_RETIRADO = 'retirado';
    const STATUS_ARQUIVADO = 'arquivado';
    const STATUS_ENVIADO_EXECUTIVO = 'enviado_executivo';
    const STATUS_SANCIONADO = 'sancionado';
    const STATUS_VETADO = 'vetado';
    const STATUS_VETO_DERRUBADO = 'veto_derrubado';
    const STATUS_VETO_MANTIDO = 'veto_mantido';
    const STATUS_PROMULGADO = 'promulgado';
    const STATUS_PUBLICADO = 'publicado';
    const STATUS_EM_CONSULTA_PUBLICA = 'em_consulta_publica';
    const STATUS_AGUARDANDO_AUDIENCIA = 'aguardando_audiencia';

    // Constantes para tipos de autoria
    const AUTORIA_VEREADOR = 'vereador';
    const AUTORIA_PREFEITO = 'prefeito';
    const AUTORIA_COMISSAO = 'comissao';
    const AUTORIA_INICIATIVA_POPULAR = 'iniciativa_popular';
    const AUTORIA_MESA_DIRETORA = 'mesa_diretora';

    // Constantes para urgência
    const URGENCIA_NORMAL = 'normal';
    const URGENCIA_URGENTE = 'urgente';
    const URGENCIA_URGENTISSIMA = 'urgentissima';

    protected $fillable = [
        'numero',
        'ano',
        'tipo',
        'titulo',
        'ementa',
        'justificativa',
        'texto_integral',
        'status',
        'data_protocolo',
        'data_aprovacao',
        'data_publicacao',
        'autor_id',
        'tipo_autoria',
        'autor_nome',
        'dados_iniciativa_popular',
        'comite_iniciativa_popular_id',
        'relator_id',
        'comissao_responsavel',
        'urgencia',
        'observacoes',
        'anexos',
        'tramitacao',
        'votacao_resultado',
        'lei_numero',
        'lei_data_sancao',
        'slug',
        'tags',
        'legislatura',
        // Novos campos para SLI - Lex Populi
        'protocolo_numero',
        'protocolo_ano',
        'protocolo_sequencial',
        'data_distribuicao',
        'data_primeira_votacao',
        'data_segunda_votacao',
        'data_envio_executivo',
        'data_retorno_executivo',
        'data_veto',
        'data_promulgacao',
        'prazo_consulta_publica',
        'data_inicio_consulta',
        'data_fim_consulta',
        'participacao_cidada',
        'termometro_popular',
        'impacto_orcamentario',
        'relatorio_impacto',
        'quorum_necessario',
        'votos_favoraveis',
        'votos_contrarios',
        'abstencoes',
        'ausencias',
        'resultado_primeira_votacao',
        'resultado_segunda_votacao',
        'motivo_veto',
        'fundamentacao_veto',
        'parecer_juridico',
        'parecer_tecnico',
        'audiencias_publicas',
        'emendas_apresentadas',
        'substitutivos',
        'historico_tramitacao',
        'documentos_anexos',
        'consulta_publica_ativa',
        'permite_participacao_cidada',
        'exige_audiencia_publica',
        'exige_maioria_absoluta',
        'exige_dois_turnos',
        'bypass_executivo'
    ];

    protected $casts = [
        'data_protocolo' => 'date',
        'data_aprovacao' => 'date',
        'data_publicacao' => 'date',
        'lei_data_sancao' => 'date',
        'urgencia' => 'boolean',
        'anexos' => 'array',
        'tramitacao' => 'array',
        'votacao_resultado' => 'array',
        'tags' => 'array',
        'dados_iniciativa_popular' => 'array',
        // Novos casts para SLI - Lex Populi
        'data_distribuicao' => 'date',
        'data_primeira_votacao' => 'date',
        'data_segunda_votacao' => 'date',
        'data_envio_executivo' => 'date',
        'data_retorno_executivo' => 'date',
        'data_veto' => 'date',
        'data_promulgacao' => 'date',
        'data_inicio_consulta' => 'date',
        'data_fim_consulta' => 'date',
        'participacao_cidada' => 'array',
        'termometro_popular' => 'array',
        'impacto_orcamentario' => 'decimal:2',
        'relatorio_impacto' => 'array',
        'votos_favoraveis' => 'integer',
        'votos_contrarios' => 'integer',
        'abstencoes' => 'integer',
        'ausencias' => 'integer',
        'resultado_primeira_votacao' => 'array',
        'resultado_segunda_votacao' => 'array',
        'audiencias_publicas' => 'array',
        'emendas_apresentadas' => 'array',
        'substitutivos' => 'array',
        'historico_tramitacao' => 'array',
        'documentos_anexos' => 'array',
        'consulta_publica_ativa' => 'boolean',
        'permite_participacao_cidada' => 'boolean',
        'exige_audiencia_publica' => 'boolean',
        'exige_maioria_absoluta' => 'boolean',
        'exige_dois_turnos' => 'boolean',
        'bypass_executivo' => 'boolean'
    ];

    protected $dates = [
        'data_protocolo',
        'data_aprovacao',
        'data_publicacao',
        'lei_data_sancao',
        'deleted_at'
    ];

    // Relacionamentos
    public function autor()
    {
        return $this->belongsTo(Vereador::class, 'autor_id');
    }

    public function relator()
    {
        return $this->belongsTo(Vereador::class, 'relator_id');
    }

    public function sessoes()
    {
        return $this->belongsToMany(Sessao::class, 'sessao_projeto_lei')
                    ->withPivot(['ordem_pauta', 'resultado_votacao', 'observacoes'])
                    ->withTimestamps();
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'projeto_lei_id');
    }

    public function coautores()
    {
        return $this->belongsToMany(Vereador::class, 'projeto_lei_coautor')
                    ->withTimestamps();
    }

    public function comiteIniciativaPopular()
    {
        return $this->belongsTo(ComiteIniciativaPopular::class, 'comite_iniciativa_popular_id');
    }

    // Métodos para diferentes tipos de autoria
    public function getAutorCompleto()
    {
        switch ($this->tipo_autoria) {
            case 'vereador':
                return $this->autor ? $this->autor->nome : 'Vereador não encontrado';
            case 'prefeito':
                return 'Prefeito Municipal';
            case 'comissao':
                return $this->autor_nome ?: 'Comissão da Câmara';
            case 'iniciativa_popular':
                if ($this->comiteIniciativaPopular) {
                    return $this->comiteIniciativaPopular->nome;
                }
                return $this->autor_nome ?: 'Iniciativa Popular';
            default:
                return $this->autor_nome ?: 'Autor não definido';
        }
    }

    public function getDetalhesIniciativaPopular()
    {
        if ($this->tipo_autoria === 'iniciativa_popular') {
            // Prioriza dados do comitê se existir
            if ($this->comiteIniciativaPopular) {
                return [
                    'responsavel' => $this->comiteIniciativaPopular->nome,
                    'assinaturas' => $this->comiteIniciativaPopular->numero_assinaturas,
                    'minimo_assinaturas' => $this->comiteIniciativaPopular->minimo_assinaturas,
                    'status' => $this->comiteIniciativaPopular->status,
                    'email' => $this->comiteIniciativaPopular->email,
                    'telefone' => $this->comiteIniciativaPopular->telefone,
                ];
            }
            // Fallback para dados JSON antigos
            if ($this->dados_iniciativa_popular) {
                return $this->dados_iniciativa_popular;
            }
        }
        return null;
    }

    public function isIniciativaPopular()
    {
        return $this->tipo_autoria === 'iniciativa_popular';
    }

    public function isAutoriaExecutivo()
    {
        return $this->tipo_autoria === 'prefeito';
    }

    public function isAutoriaComissao()
    {
        return $this->tipo_autoria === 'comissao';
    }

    public function isAutoriaVereador()
    {
        return $this->tipo_autoria === 'vereador';
    }

    // Scopes
    public function scopeAprovados($query)
    {
        return $query->where('status', 'aprovado');
    }

    public function scopeRejeitados($query)
    {
        return $query->where('status', 'rejeitado');
    }

    public function scopeTramitando($query)
    {
        return $query->where('status', 'tramitando');
    }

    public function scopeArquivados($query)
    {
        return $query->where('status', 'arquivado');
    }

    public function scopeSancionados($query)
    {
        return $query->where('status', 'sancionado');
    }

    public function scopeVetados($query)
    {
        return $query->where('status', 'vetado');
    }

    public function scopeUrgentes($query)
    {
        return $query->where('urgencia', true);
    }

    public function scopeAno($query, $ano)
    {
        return $query->where('ano', $ano);
    }

    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeAutor($query, $autorId)
    {
        return $query->where('autor_id', $autorId);
    }

    public function scopeRelator($query, $relatorId)
    {
        return $query->where('relator_id', $relatorId);
    }

    public function scopeComissao($query, $comissao)
    {
        return $query->where('comissao_responsavel', $comissao);
    }

    public function scopeTipoAutoria($query, $tipoAutoria)
    {
        return $query->where('tipo_autoria', $tipoAutoria);
    }

    public function scopeIniciativaPopular($query)
    {
        return $query->where('tipo_autoria', 'iniciativa_popular');
    }

    public function scopeAutoriaExecutivo($query)
    {
        return $query->where('tipo_autoria', 'prefeito');
    }

    public function scopeAutoriaComissao($query)
    {
        return $query->where('tipo_autoria', 'comissao');
    }

    public function scopeAutoriaVereador($query)
    {
        return $query->where('tipo_autoria', 'vereador');
    }

    // Accessors
    protected function numeroCompleto(): Attribute
    {
        return Attribute::make(
            get: fn () => sprintf('%03d/%d', $this->numero, $this->ano),
        );
    }

    protected function dataProtocoloFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_protocolo?->format('d/m/Y'),
        );
    }

    protected function dataAprovacaoFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_aprovacao?->format('d/m/Y'),
        );
    }

    protected function dataPublicacaoFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_publicacao?->format('d/m/Y'),
        );
    }

    protected function leiDataSancaoFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->lei_data_sancao?->format('d/m/Y'),
        );
    }

    protected function statusFormatado(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->status) {
                'apresentado' => 'Apresentado',
                'tramitando' => 'Em Tramitação',
                'aprovado' => 'Aprovado',
                'rejeitado' => 'Rejeitado',
                'arquivado' => 'Arquivado',
                'sancionado' => 'Sancionado',
                'vetado' => 'Vetado',
                'promulgado' => 'Promulgado',
                default => 'Indefinido'
            },
        );
    }

    protected function tipoFormatado(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->tipo) {
                'projeto_lei' => 'Projeto de Lei',
                'projeto_lei_complementar' => 'Projeto de Lei Complementar',
                'projeto_resolucao' => 'Projeto de Resolução',
                'projeto_decreto_legislativo' => 'Projeto de Decreto Legislativo',
                'emenda' => 'Emenda',
                'substitutivo' => 'Substitutivo',
                default => 'Indefinido'
            },
        );
    }

    protected function ementaResumo(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::limit($this->ementa, 100),
        );
    }

    protected function tempoTramitacao(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_protocolo 
                ? $this->data_protocolo->diffInDays(now()) 
                : null,
        );
    }

    // Mutators
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ?: Str::slug($this->numero_completo . '-' . Str::limit($this->ementa, 50)),
        );
    }

    // Métodos auxiliares
    public function isAprovado()
    {
        return $this->status === 'aprovado';
    }

    /**
     * Retorna o tempo de tramitação formatado
     */
    public function getTempoTramitacao()
    {
        if (!$this->data_protocolo) {
            return 'Não informado';
        }

        $dias = $this->data_protocolo->diffInDays(now());
        
        if ($dias == 0) {
            return 'Hoje';
        } elseif ($dias == 1) {
            return '1 dia';
        } elseif ($dias < 30) {
            return $dias . ' dias';
        } elseif ($dias < 365) {
            $meses = floor($dias / 30);
            $diasRestantes = $dias % 30;
            
            if ($meses == 1) {
                return $diasRestantes > 0 ? "1 mês e {$diasRestantes} dias" : '1 mês';
            } else {
                return $diasRestantes > 0 ? "{$meses} meses e {$diasRestantes} dias" : "{$meses} meses";
            }
        } else {
            $anos = floor($dias / 365);
            $diasRestantes = $dias % 365;
            
            if ($anos == 1) {
                return $diasRestantes > 0 ? "1 ano e {$diasRestantes} dias" : '1 ano';
            } else {
                return $diasRestantes > 0 ? "{$anos} anos e {$diasRestantes} dias" : "{$anos} anos";
            }
        }
    }

    /**
     * Gera número de protocolo automático para projetos legislativos
     */
    public function gerarProtocolo()
    {
        $ano = now()->year;
        $prefixo = $this->getPrefixoProtocolo();
        
        // Busca o último protocolo do ano para o tipo específico
        $ultimoProtocolo = self::where('protocolo_ano', $ano)
            ->where('tipo', $this->tipo)
            ->max('protocolo_sequencial') ?? 0;
        
        $sequencial = $ultimoProtocolo + 1;
        
        $this->protocolo_ano = $ano;
        $this->protocolo_sequencial = $sequencial;
        $this->protocolo_numero = sprintf('%s%04d%06d', $prefixo, $ano, $sequencial);
        
        return $this->protocolo_numero;
    }

    /**
     * Retorna o prefixo do protocolo baseado no tipo de proposição
     */
    private function getPrefixoProtocolo()
    {
        $prefixos = [
            self::TIPO_LEI_ORDINARIA => 'PLO',
            self::TIPO_LEI_COMPLEMENTAR => 'PLC',
            self::TIPO_EMENDA_LOM => 'ELO',
            self::TIPO_DECRETO_LEGISLATIVO => 'PDL',
            self::TIPO_RESOLUCAO => 'PRS',
            self::TIPO_MOCAO => 'MOC',
            self::TIPO_REQUERIMENTO => 'REQ',
            self::TIPO_INDICACAO => 'IND'
        ];

        return $prefixos[$this->tipo] ?? 'PL';
    }

    /**
     * Verifica se o projeto está em tramitação
     */
    public function isEmTramitacao()
    {
        return in_array($this->status, [
            self::STATUS_PROTOCOLADO,
            self::STATUS_DISTRIBUIDO,
            self::STATUS_EM_COMISSAO,
            self::STATUS_PRONTO_PAUTA,
            self::STATUS_EM_VOTACAO,
            self::STATUS_ENVIADO_EXECUTIVO
        ]);
    }

    /**
     * Verifica se o projeto foi finalizado
     */
    public function isFinalizado()
    {
        return in_array($this->status, [
            self::STATUS_APROVADO,
            self::STATUS_REJEITADO,
            self::STATUS_ARQUIVADO,
            self::STATUS_SANCIONADO,
            self::STATUS_VETADO,
            self::STATUS_PROMULGADO
        ]);
    }

    /**
     * Verifica se o projeto exige dois turnos de votação
     */
    public function exigeDoisTurnos()
    {
        return $this->exige_dois_turnos || 
               $this->tipo === self::TIPO_LEI_COMPLEMENTAR ||
               $this->tipo === self::TIPO_EMENDA_LOM;
    }

    /**
     * Verifica se o projeto exige maioria absoluta
     */
    public function exigeMaioriaAbsoluta()
    {
        return $this->exige_maioria_absoluta ||
               $this->tipo === self::TIPO_LEI_COMPLEMENTAR ||
               $this->tipo === self::TIPO_EMENDA_LOM;
    }

    /**
     * Calcula o termômetro popular (percentual de aprovação)
     */
    public function getTermometroPopularPercentual()
    {
        if (!$this->termometro_popular || !is_array($this->termometro_popular)) {
            return 0;
        }

        $favoraveis = $this->termometro_popular['favoraveis'] ?? 0;
        $contrarios = $this->termometro_popular['contrarios'] ?? 0;
        $total = $favoraveis + $contrarios;

        return $total > 0 ? round(($favoraveis / $total) * 100, 1) : 0;
    }

    /**
     * Adiciona entrada no histórico de tramitação
     */
    public function adicionarHistoricoTramitacao($acao, $observacao = null, $usuario_id = null)
    {
        $historico = $this->historico_tramitacao ?? [];
        
        $entrada = [
            'data' => now()->toISOString(),
            'acao' => $acao,
            'status_anterior' => $this->getOriginal('status'),
            'status_atual' => $this->status,
            'observacao' => $observacao,
            'usuario_id' => $usuario_id ?? auth()->id(),
            'usuario_nome' => auth()->user()->name ?? 'Sistema'
        ];

        $historico[] = $entrada;
        $this->historico_tramitacao = $historico;
        
        return $this;
    }

    /**
     * Inicia consulta pública
     */
    public function iniciarConsultaPublica($prazo_dias = 15)
    {
        $this->data_inicio_consulta = now();
        $this->data_fim_consulta = now()->addDays($prazo_dias);
        $this->consulta_publica_ativa = true;
        $this->prazo_consulta_publica = $prazo_dias;
        
        $this->adicionarHistoricoTramitacao('Consulta Pública Iniciada', "Prazo: {$prazo_dias} dias");
        
        return $this;
    }

    /**
     * Finaliza consulta pública
     */
    public function finalizarConsultaPublica()
    {
        $this->consulta_publica_ativa = false;
        $this->adicionarHistoricoTramitacao('Consulta Pública Finalizada');
        
        return $this;
    }

    public function isRejeitado()
    {
        return $this->status === 'rejeitado';
    }

    public function isTramitando()
    {
        return $this->status === 'tramitando';
    }

    public function isArquivado()
    {
        return $this->status === 'arquivado';
    }

    public function isSancionado()
    {
        return $this->status === 'sancionado';
    }

    public function isVetado()
    {
        return $this->status === 'vetado';
    }

    public function isPromulgado()
    {
        return $this->status === 'promulgado';
    }

    public function isUrgente()
    {
        return $this->urgencia === true;
    }

    public function temAnexos()
    {
        return !empty($this->anexos);
    }

    public function getTotalAnexos()
    {
        return collect($this->anexos)->count();
    }

    public function getHistoricoTramitacao()
    {
        return collect($this->tramitacao)->sortBy('data');
    }

    public function getUltimaTramitacao()
    {
        return collect($this->tramitacao)->sortByDesc('data')->first();
    }

    public function adicionarTramitacao($descricao, $data = null, $responsavel = null)
    {
        $tramitacao = $this->tramitacao ?? [];
        $tramitacao[] = [
            'descricao' => $descricao,
            'data' => $data ?: now()->toISOString(),
            'responsavel' => $responsavel,
            'id' => Str::uuid()
        ];
        $this->update(['tramitacao' => $tramitacao]);
    }

    public function adicionarAnexo($nome, $caminho, $tipo = null, $tamanho = null)
    {
        $anexos = $this->anexos ?? [];
        $anexos[] = [
            'nome' => $nome,
            'caminho' => $caminho,
            'tipo' => $tipo,
            'tamanho' => $tamanho,
            'data_upload' => now()->toISOString(),
            'id' => Str::uuid()
        ];
        $this->update(['anexos' => $anexos]);
    }

    public function removerAnexo($anexoId)
    {
        $anexos = collect($this->anexos)->reject(function ($anexo) use ($anexoId) {
            return $anexo['id'] === $anexoId;
        })->values()->toArray();
        
        $this->update(['anexos' => $anexos]);
    }

    public function registrarVotacao($resultado, $detalhes = [])
    {
        $this->update([
            'votacao_resultado' => [
                'resultado' => $resultado,
                'detalhes' => $detalhes,
                'data_votacao' => now()->toISOString()
            ]
        ]);
    }

    public function podeSerEditado()
    {
        return in_array($this->status, ['apresentado', 'tramitando']);
    }

    public function podeSerVotado()
    {
        return $this->status === 'tramitando';
    }

    public function gerarNumeroSequencial($ano = null)
    {
        $ano = $ano ?: now()->year;
        $ultimoNumero = static::where('ano', $ano)->max('numero') ?? 0;
        return $ultimoNumero + 1;
    }

    // Boot method para auto-gerar slug e número
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($projeto) {
            if (empty($projeto->slug)) {
                $projeto->slug = Str::slug($projeto->numero_completo . '-' . Str::limit($projeto->ementa, 50));
            }
            
            if (empty($projeto->numero)) {
                $projeto->numero = $projeto->gerarNumeroSequencial($projeto->ano);
            }
        });

        static::updating(function ($projeto) {
            if ($projeto->isDirty(['numero', 'ano', 'ementa']) && empty($projeto->slug)) {
                $projeto->slug = Str::slug($projeto->numero_completo . '-' . Str::limit($projeto->ementa, 50));
            }
        });
    }

    // Validações customizadas
    public static function rules($id = null)
    {
        return [
            'numero' => 'required|integer|min:1',
            'ano' => 'required|integer|min:1900|max:' . (now()->year + 10),
            'tipo' => 'required|in:projeto_lei,projeto_lei_complementar,projeto_resolucao,projeto_decreto_legislativo,emenda,substitutivo',
            'ementa' => 'required|string|min:10|max:1000',
            'justificativa' => 'nullable|string|max:5000',
            'texto_integral' => 'nullable|string',
            'status' => 'required|in:apresentado,tramitando,aprovado,rejeitado,arquivado,sancionado,vetado,promulgado',
            'data_protocolo' => 'required|date',
            'data_aprovacao' => 'nullable|date|after_or_equal:data_protocolo',
            'data_publicacao' => 'nullable|date|after_or_equal:data_aprovacao',
            'autor_id' => 'required|exists:vereadores,id',
            'relator_id' => 'nullable|exists:vereadores,id',
            'comissao_responsavel' => 'nullable|string|max:100',
            'urgencia' => 'boolean',
            'lei_numero' => 'nullable|string|max:20',
            'lei_data_sancao' => 'nullable|date',
            'slug' => 'nullable|string|max:255|unique:projetos_lei,slug,' . $id
        ];
    }

    public static function messages()
    {
        return [
            'numero.required' => 'O número do projeto é obrigatório.',
            'numero.integer' => 'O número deve ser um valor inteiro.',
            'numero.min' => 'O número deve ser maior que zero.',
            'ano.required' => 'O ano é obrigatório.',
            'ano.integer' => 'O ano deve ser um valor inteiro.',
            'ano.min' => 'O ano deve ser maior que 1900.',
            'ano.max' => 'O ano não pode ser superior a ' . (now()->year + 10) . '.',
            'tipo.required' => 'O tipo do projeto é obrigatório.',
            'tipo.in' => 'O tipo deve ser: projeto de lei, projeto de lei complementar, projeto de resolução, projeto de decreto legislativo, emenda ou substitutivo.',
            'ementa.required' => 'A ementa é obrigatória.',
            'ementa.min' => 'A ementa deve ter pelo menos 10 caracteres.',
            'ementa.max' => 'A ementa não pode exceder 1000 caracteres.',
            'justificativa.max' => 'A justificativa não pode exceder 5000 caracteres.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser: apresentado, tramitando, aprovado, rejeitado, arquivado, sancionado, vetado ou promulgado.',
            'data_protocolo.required' => 'A data de protocolo é obrigatória.',
            'data_protocolo.date' => 'A data de protocolo deve ser uma data válida.',
            'data_aprovacao.date' => 'A data de aprovação deve ser uma data válida.',
            'data_aprovacao.after_or_equal' => 'A data de aprovação deve ser posterior ou igual à data de protocolo.',
            'data_publicacao.date' => 'A data de publicação deve ser uma data válida.',
            'data_publicacao.after_or_equal' => 'A data de publicação deve ser posterior ou igual à data de aprovação.',
            'autor_id.required' => 'O autor é obrigatório.',
            'autor_id.exists' => 'O autor selecionado não existe.',
            'relator_id.exists' => 'O relator selecionado não existe.',
            'comissao_responsavel.max' => 'O nome da comissão não pode exceder 100 caracteres.',
            'lei_numero.max' => 'O número da lei não pode exceder 20 caracteres.',
            'lei_data_sancao.date' => 'A data de sanção deve ser uma data válida.',
            'slug.unique' => 'Este slug já está em uso.'
        ];
    }

    // Métodos de busca
    public static function search($query)
    {
        return self::where(function ($q) use ($query) {
                $q->where('ementa', 'LIKE', "%{$query}%")
                  ->orWhere('justificativa', 'LIKE', "%{$query}%")
                  ->orWhere('texto_integral', 'LIKE', "%{$query}%")
                  ->orWhere('tipo', 'LIKE', "%{$query}%")
                  ->orWhere('lei_numero', 'LIKE', "%{$query}%")
                  ->orWhereRaw("CONCAT(numero, '/', ano) LIKE ?", ["%{$query}%"]);
            })
            ->orderBy('data_protocolo', 'desc');
    }

    public function getSearchableContent()
    {
        return [
            'numero_ano' => $this->numero . '/' . $this->ano,
            'tipo' => $this->tipo,
            'ementa' => $this->ementa,
            'justificativa' => strip_tags($this->justificativa),
            'status' => $this->status,
            'lei_numero' => $this->lei_numero,
        ];
    }

    public function getSearchUrl()
    {
        return route('projetos-lei.show', $this->slug ?: $this->id);
    }

    public function getSearchType()
    {
        return 'Projeto de Lei';
    }

    public function getSearchDate()
    {
        return $this->data_protocolo;
    }
}
