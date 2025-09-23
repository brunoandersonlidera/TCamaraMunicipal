<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EsicSolicitacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'esic_solicitacoes';

    protected $fillable = [
        'protocolo',
        'user_id',
        'nome_solicitante',
        'email_solicitante',
        'telefone_solicitante',
        'cpf_solicitante',
        'endereco_solicitante',
        'assunto',
        'descricao',
        'categoria',
        'subcategoria',
        'forma_recebimento',
        'status',
        'arquivada',
        'arquivada_em',
        'prioridade',
        'data_solicitacao',
        'data_limite_resposta',
        'data_resposta',
        'resposta',
        'responsavel_id',
        'observacoes_internas',
        'anexos',
        'metadata',
        'ip_solicitante',
        'user_agent',
        'origem',
        'anonima',
        'recurso_primeira_instancia',
        'recurso_segunda_instancia',
        'data_recurso_primeira',
        'data_recurso_segunda',
        'resposta_recurso_primeira',
        'resposta_recurso_segunda',
        'classificacao_informacao',
        'fundamentacao_legal',
        'tags'
    ];

    protected $casts = [
        'data_solicitacao' => 'datetime',
        'data_limite_resposta' => 'datetime',
        'data_resposta' => 'datetime',
        'data_recurso_primeira' => 'datetime',
        'data_recurso_segunda' => 'datetime',
        'arquivada_em' => 'datetime',
        'anexos' => 'array',
        'metadata' => 'array',
        'tags' => 'array',
        'anonima' => 'boolean',
        'arquivada' => 'boolean',
        'recurso_primeira_instancia' => 'boolean',
        'recurso_segunda_instancia' => 'boolean'
    ];

    protected $dates = [
        'data_solicitacao',
        'data_limite_resposta',
        'data_resposta',
        'data_recurso_primeira',
        'data_recurso_segunda',
        'arquivada_em',
        'deleted_at'
    ];

    // Constantes para status
    const STATUS_PENDENTE = 'pendente';
    const STATUS_EM_ANALISE = 'em_analise';
    const STATUS_AGUARDANDO_INFORMACOES = 'aguardando_informacoes';
    const STATUS_RESPONDIDA = 'respondida';
    const STATUS_NEGADA = 'negada';
    const STATUS_PARCIALMENTE_ATENDIDA = 'parcialmente_atendida';
    const STATUS_FINALIZADA = 'finalizada';
    const STATUS_CANCELADA = 'cancelada';
    const STATUS_EXPIRADA = 'expirada';

    // Constantes para prioridade
    const PRIORIDADE_BAIXA = 'baixa';
    const PRIORIDADE_NORMAL = 'normal';
    const PRIORIDADE_ALTA = 'alta';
    const PRIORIDADE_URGENTE = 'urgente';

    // Constantes para categoria
    const CATEGORIA_FINANCEIRO = 'financeiro';
    const CATEGORIA_ADMINISTRATIVO = 'administrativo';
    const CATEGORIA_LEGISLATIVO = 'legislativo';
    const CATEGORIA_RECURSOS_HUMANOS = 'recursos_humanos';
    const CATEGORIA_LICITACOES = 'licitacoes';
    const CATEGORIA_CONTRATOS = 'contratos';
    const CATEGORIA_TRANSPARENCIA = 'transparencia';
    const CATEGORIA_OUTROS = 'outros';

    // Constantes para forma de recebimento
    const FORMA_EMAIL = 'email';
    const FORMA_CORREIO = 'correio';
    const FORMA_PRESENCIAL = 'presencial';
    const FORMA_SISTEMA = 'sistema';

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function movimentacoes()
    {
        return $this->hasMany(EsicMovimentacao::class, 'esic_solicitacao_id');
    }

    public function ultimaMovimentacao()
    {
        return $this->hasOne(EsicMovimentacao::class, 'esic_solicitacao_id')->latest('data_movimentacao');
    }

    // Scopes
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePendentes($query)
    {
        return $query->where('status', self::STATUS_PENDENTE);
    }

    public function scopeEmAnalise($query)
    {
        return $query->where('status', self::STATUS_EM_ANALISE);
    }

    public function scopeRespondidas($query)
    {
        return $query->where('status', self::STATUS_RESPONDIDA);
    }

    public function scopeNegadas($query)
    {
        return $query->where('status', self::STATUS_NEGADA);
    }

    public function scopeExpiradas($query)
    {
        return $query->where('status', self::STATUS_EXPIRADA);
    }

    public function scopeVencidas($query)
    {
        return $query->where('data_limite_resposta', '<', now())
                    ->whereNotIn('status', [self::STATUS_RESPONDIDA, self::STATUS_CANCELADA]);
    }

    public function scopeVencendoEm($query, $dias = 3)
    {
        return $query->where('data_limite_resposta', '<=', now()->addDays($dias))
                    ->where('data_limite_resposta', '>=', now())
                    ->whereNotIn('status', [self::STATUS_RESPONDIDA, self::STATUS_CANCELADA]);
    }

    public function scopePrioridade($query, $prioridade)
    {
        return $query->where('prioridade', $prioridade);
    }

    public function scopeCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeAnonimas($query)
    {
        return $query->where('anonima', true);
    }

    public function scopeIdentificadas($query)
    {
        return $query->where('anonima', false);
    }

    public function scopeComRecurso($query)
    {
        return $query->where(function ($q) {
            $q->where('recurso_primeira_instancia', true)
              ->orWhere('recurso_segunda_instancia', true);
        });
    }

    public function scopeResponsavel($query, $responsavelId)
    {
        return $query->where('responsavel_id', $responsavelId);
    }

    public function scopePeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('data_solicitacao', [$dataInicio, $dataFim]);
    }

    public function scopeComTags($query, $tags)
    {
        if (is_string($tags)) {
            $tags = [$tags];
        }
        
        return $query->where(function ($q) use ($tags) {
            foreach ($tags as $tag) {
                $q->orWhereJsonContains('tags', $tag);
            }
        });
    }

    // Accessors
    protected function statusFormatado(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->status) {
                self::STATUS_PENDENTE => 'Pendente',
                self::STATUS_EM_ANALISE => 'Em Análise',
                self::STATUS_AGUARDANDO_INFORMACOES => 'Aguardando Informações',
                self::STATUS_RESPONDIDA => 'Respondida',
                self::STATUS_NEGADA => 'Negada',
                self::STATUS_PARCIALMENTE_ATENDIDA => 'Parcialmente Atendida',
                self::STATUS_FINALIZADA => 'Finalizada',
                self::STATUS_CANCELADA => 'Cancelada',
                self::STATUS_EXPIRADA => 'Expirada',
                default => 'Indefinido'
            },
        );
    }

    protected function prioridadeFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->prioridade) {
                self::PRIORIDADE_BAIXA => 'Baixa',
                self::PRIORIDADE_NORMAL => 'Normal',
                self::PRIORIDADE_ALTA => 'Alta',
                self::PRIORIDADE_URGENTE => 'Urgente',
                default => 'Normal'
            },
        );
    }

    protected function categoriaFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->categoria) {
                self::CATEGORIA_FINANCEIRO => 'Financeiro',
                self::CATEGORIA_ADMINISTRATIVO => 'Administrativo',
                self::CATEGORIA_LEGISLATIVO => 'Legislativo',
                self::CATEGORIA_RECURSOS_HUMANOS => 'Recursos Humanos',
                self::CATEGORIA_LICITACOES => 'Licitações',
                self::CATEGORIA_CONTRATOS => 'Contratos',
                self::CATEGORIA_TRANSPARENCIA => 'Transparência',
                self::CATEGORIA_OUTROS => 'Outros',
                default => 'Indefinido'
            },
        );
    }

    protected function formaRecebimentoFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->forma_recebimento) {
                self::FORMA_EMAIL => 'E-mail',
                self::FORMA_CORREIO => 'Correio',
                self::FORMA_PRESENCIAL => 'Presencial',
                self::FORMA_SISTEMA => 'Sistema',
                default => 'Sistema'
            },
        );
    }

    protected function dataSolicitacaoFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_solicitacao?->format('d/m/Y H:i'),
        );
    }

    protected function dataLimiteRespostaFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_limite_resposta?->format('d/m/Y'),
        );
    }

    protected function dataRespostaFormatada(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_resposta?->format('d/m/Y H:i'),
        );
    }

    protected function diasParaVencimento(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_limite_resposta 
                ? now()->diffInDays($this->data_limite_resposta, false)
                : null,
        );
    }

    protected function tempoResposta(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data_resposta && $this->data_solicitacao
                ? $this->data_solicitacao->diffInDays($this->data_resposta)
                : null,
        );
    }

    protected function nomeExibicao(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->anonima ? 'Solicitação Anônima' : $this->nome_solicitante,
        );
    }

    protected function emailExibicao(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->anonima ? '***@***.***' : $this->email_solicitante,
        );
    }

    protected function cpfExibicao(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->anonima ? '***.***.***-**' : $this->formatarCpf($this->cpf_solicitante),
        );
    }

    // Mutators
    protected function protocolo(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ?: $this->gerarProtocolo(),
        );
    }

    protected function tags(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => is_string($value) 
                ? array_map('trim', explode(',', $value))
                : $value,
        );
    }

    // Métodos auxiliares
    public function isPendente()
    {
        return $this->status === self::STATUS_PENDENTE;
    }

    public function isEmAnalise()
    {
        return $this->status === self::STATUS_EM_ANALISE;
    }

    public function isRespondida()
    {
        return $this->status === self::STATUS_RESPONDIDA;
    }

    public function isNegada()
    {
        return $this->status === self::STATUS_NEGADA;
    }

    public function isCancelada()
    {
        return $this->status === self::STATUS_CANCELADA;
    }

    public function isExpirada()
    {
        return $this->status === self::STATUS_EXPIRADA;
    }

    public function isVencida()
    {
        return $this->data_limite_resposta < now() && 
               !in_array($this->status, [self::STATUS_RESPONDIDA, self::STATUS_CANCELADA]);
    }

    public function isVencendoEm($dias = 3)
    {
        return $this->data_limite_resposta <= now()->addDays($dias) &&
               $this->data_limite_resposta >= now() &&
               !in_array($this->status, [self::STATUS_RESPONDIDA, self::STATUS_CANCELADA]);
    }

    public function isAnonima()
    {
        return $this->anonima === true;
    }

    public function temRecurso()
    {
        return $this->recurso_primeira_instancia || $this->recurso_segunda_instancia;
    }

    public function podeSerRespondida()
    {
        return in_array($this->status, [
            self::STATUS_PENDENTE,
            self::STATUS_EM_ANALISE,
            self::STATUS_AGUARDANDO_INFORMACOES
        ]);
    }

    public function podeSerCancelada()
    {
        return !in_array($this->status, [
            self::STATUS_RESPONDIDA,
            self::STATUS_CANCELADA,
            self::STATUS_EXPIRADA
        ]);
    }

    public function podeReceberRecurso()
    {
        return $this->status === self::STATUS_NEGADA && 
               !$this->recurso_segunda_instancia;
    }

    public function responder($resposta, $responsavelId = null)
    {
        $this->update([
            'resposta' => $resposta,
            'data_resposta' => now(),
            'status' => self::STATUS_RESPONDIDA,
            'responsavel_id' => $responsavelId ?: Auth::id()
        ]);
    }

    public function negar($justificativa, $responsavelId = null)
    {
        $this->update([
            'resposta' => $justificativa,
            'data_resposta' => now(),
            'status' => self::STATUS_NEGADA,
            'responsavel_id' => $responsavelId ?: Auth::id()
        ]);
    }

    public function cancelar($motivo = null, $responsavelId = null)
    {
        $this->update([
            'status' => self::STATUS_CANCELADA,
            'observacoes_internas' => $motivo,
            'responsavel_id' => $responsavelId ?: Auth::id()
        ]);
    }

    public function marcarComoEmAnalise($responsavelId = null)
    {
        $this->update([
            'status' => self::STATUS_EM_ANALISE,
            'responsavel_id' => $responsavelId ?: Auth::id()
        ]);
    }

    public function adicionarRecursoPrimeiraInstancia($recurso)
    {
        $this->update([
            'recurso_primeira_instancia' => true,
            'data_recurso_primeira' => now(),
            'resposta_recurso_primeira' => $recurso,
            'status' => self::STATUS_EM_ANALISE
        ]);
    }

    public function adicionarRecursoSegundaInstancia($recurso)
    {
        $this->update([
            'recurso_segunda_instancia' => true,
            'data_recurso_segunda' => now(),
            'resposta_recurso_segunda' => $recurso,
            'status' => self::STATUS_EM_ANALISE
        ]);
    }

    public function adicionarTag($tag)
    {
        $tags = $this->tags ?? [];
        if (!in_array($tag, $tags)) {
            $tags[] = $tag;
            $this->update(['tags' => $tags]);
        }
    }

    public function removerTag($tag)
    {
        $tags = collect($this->tags)->reject(fn($t) => $t === $tag)->values()->toArray();
        $this->update(['tags' => $tags]);
    }

    public function adicionarMetadata($chave, $valor)
    {
        $metadata = $this->metadata ?? [];
        $metadata[$chave] = $valor;
        $this->update(['metadata' => $metadata]);
    }

    public function obterMetadata($chave, $default = null)
    {
        return data_get($this->metadata, $chave, $default);
    }

    public function calcularDataLimite($diasUteis = 20)
    {
        $data = $this->data_solicitacao ?: now();
        $dataLimite = $data->copy();
        
        $diasAdicionados = 0;
        while ($diasAdicionados < $diasUteis) {
            $dataLimite->addDay();
            // Pula fins de semana (sábado = 6, domingo = 0)
            if (!in_array($dataLimite->dayOfWeek, [0, 6])) {
                $diasAdicionados++;
            }
        }
        
        return $dataLimite;
    }

    public function gerarProtocolo()
    {
        $ano = now()->year;
        $sequencial = static::whereYear('created_at', $ano)->count() + 1;
        return sprintf('ESIC%d%06d', $ano, $sequencial);
    }

    public function verificarVencimento()
    {
        if ($this->isVencida() && !$this->isExpirada()) {
            $this->update(['status' => self::STATUS_EXPIRADA]);
        }
    }

    private function formatarCpf($cpf)
    {
        if (!$cpf) return null;
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
    }

    public function duplicar()
    {
        $solicitacao = $this->replicate();
        $solicitacao->protocolo = null; // Será gerado automaticamente
        $solicitacao->status = self::STATUS_PENDENTE;
        $solicitacao->data_solicitacao = now();
        $solicitacao->data_limite_resposta = $solicitacao->calcularDataLimite();
        $solicitacao->data_resposta = null;
        $solicitacao->resposta = null;
        $solicitacao->responsavel_id = null;
        $solicitacao->save();
        
        return $solicitacao;
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($solicitacao) {
            if (empty($solicitacao->protocolo)) {
                $solicitacao->protocolo = $solicitacao->gerarProtocolo();
            }
            
            if (empty($solicitacao->data_solicitacao)) {
                $solicitacao->data_solicitacao = now();
            }
            
            if (empty($solicitacao->data_limite_resposta)) {
                $solicitacao->data_limite_resposta = $solicitacao->calcularDataLimite();
            }
            
            if (empty($solicitacao->status)) {
                $solicitacao->status = self::STATUS_PENDENTE;
            }
            
            if (empty($solicitacao->prioridade)) {
                $solicitacao->prioridade = self::PRIORIDADE_NORMAL;
            }
        });

        static::updating(function ($solicitacao) {
            // Auto-verificar vencimento ao atualizar
            $solicitacao->verificarVencimento();
        });
    }

    // Validações customizadas
    public static function rules($id = null)
    {
        return [
            'protocolo' => 'nullable|string|max:50|unique:esic_solicitacoes,protocolo,' . $id,
            'nome_solicitante' => 'required_if:anonima,false|string|max:255',
            'email_solicitante' => 'required_if:anonima,false|email|max:255',
            'telefone_solicitante' => 'nullable|string|max:20',
            'cpf_solicitante' => 'nullable|string|size:11',
            'endereco_solicitante' => 'nullable|string|max:500',
            'assunto' => 'required|string|min:5|max:255',
            'descricao' => 'required|string|min:10|max:2000',
            'categoria' => 'required|in:' . implode(',', [
                self::CATEGORIA_FINANCEIRO,
                self::CATEGORIA_ADMINISTRATIVO,
                self::CATEGORIA_LEGISLATIVO,
                self::CATEGORIA_RECURSOS_HUMANOS,
                self::CATEGORIA_LICITACOES,
                self::CATEGORIA_CONTRATOS,
                self::CATEGORIA_TRANSPARENCIA,
                self::CATEGORIA_OUTROS
            ]),
            'subcategoria' => 'nullable|string|max:100',
            'forma_recebimento' => 'required|in:' . implode(',', [
                self::FORMA_EMAIL,
                self::FORMA_CORREIO,
                self::FORMA_PRESENCIAL,
                self::FORMA_SISTEMA
            ]),
            'status' => 'nullable|in:' . implode(',', [
                self::STATUS_PENDENTE,
                self::STATUS_EM_ANALISE,
                self::STATUS_AGUARDANDO_INFORMACOES,
                self::STATUS_RESPONDIDA,
                self::STATUS_NEGADA,
                self::STATUS_PARCIALMENTE_ATENDIDA,
                self::STATUS_CANCELADA,
                self::STATUS_EXPIRADA,
                self::STATUS_FINALIZADA
            ]),
            'prioridade' => 'nullable|in:' . implode(',', [
                self::PRIORIDADE_BAIXA,
                self::PRIORIDADE_NORMAL,
                self::PRIORIDADE_ALTA,
                self::PRIORIDADE_URGENTE
            ]),
            'data_solicitacao' => 'nullable|date',
            'data_limite_resposta' => 'nullable|date|after:data_solicitacao',
            'data_resposta' => 'nullable|date',
            'resposta' => 'nullable|string|max:5000',
            'responsavel_id' => 'nullable|exists:users,id',
            'observacoes_internas' => 'nullable|string|max:1000',
            'anexos' => 'nullable|array',
            'metadata' => 'nullable|array',
            'ip_solicitante' => 'nullable|ip',
            'user_agent' => 'nullable|string|max:500',
            'origem' => 'nullable|string|max:100',
            'anonima' => 'boolean',
            'recurso_primeira_instancia' => 'boolean',
            'recurso_segunda_instancia' => 'boolean',
            'data_recurso_primeira' => 'nullable|date',
            'data_recurso_segunda' => 'nullable|date',
            'resposta_recurso_primeira' => 'nullable|string|max:2000',
            'resposta_recurso_segunda' => 'nullable|string|max:2000',
            'classificacao_informacao' => 'nullable|string|max:100',
            'fundamentacao_legal' => 'nullable|string|max:500',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50'
        ];
    }

    public static function messages()
    {
        return [
            'protocolo.unique' => 'Este protocolo já está em uso.',
            'nome_solicitante.required_if' => 'O nome é obrigatório para solicitações não anônimas.',
            'email_solicitante.required_if' => 'O e-mail é obrigatório para solicitações não anônimas.',
            'email_solicitante.email' => 'O e-mail deve ter um formato válido.',
            'cpf_solicitante.size' => 'O CPF deve ter exatamente 11 dígitos.',
            'assunto.required' => 'O assunto é obrigatório.',
            'assunto.min' => 'O assunto deve ter pelo menos 5 caracteres.',
            'assunto.max' => 'O assunto não pode exceder 255 caracteres.',
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.min' => 'A descrição deve ter pelo menos 10 caracteres.',
            'descricao.max' => 'A descrição não pode exceder 2000 caracteres.',
            'categoria.required' => 'A categoria é obrigatória.',
            'categoria.in' => 'A categoria selecionada é inválida.',
            'forma_recebimento.required' => 'A forma de recebimento é obrigatória.',
            'forma_recebimento.in' => 'A forma de recebimento selecionada é inválida.',
            'status.in' => 'O status selecionado é inválido.',
            'prioridade.in' => 'A prioridade selecionada é inválida.',
            'data_limite_resposta.after' => 'A data limite deve ser posterior à data da solicitação.',
            'resposta.max' => 'A resposta não pode exceder 5000 caracteres.',
            'responsavel_id.exists' => 'O responsável selecionado não existe.',
            'observacoes_internas.max' => 'As observações internas não podem exceder 1000 caracteres.',
            'ip_solicitante.ip' => 'O IP deve ter um formato válido.',
            'user_agent.max' => 'O user agent não pode exceder 500 caracteres.',
            'origem.max' => 'A origem não pode exceder 100 caracteres.',
            'resposta_recurso_primeira.max' => 'A resposta do recurso não pode exceder 2000 caracteres.',
            'resposta_recurso_segunda.max' => 'A resposta do recurso não pode exceder 2000 caracteres.',
            'classificacao_informacao.max' => 'A classificação não pode exceder 100 caracteres.',
            'fundamentacao_legal.max' => 'A fundamentação legal não pode exceder 500 caracteres.',
            'tags.array' => 'As tags devem ser um array.',
            'tags.*.string' => 'Cada tag deve ser uma string.',
            'tags.*.max' => 'Cada tag não pode exceder 50 caracteres.'
        ];
    }

    /**
     * Retorna as categorias disponíveis
     */
    public static function getCategorias()
    {
        return [
            self::CATEGORIA_FINANCEIRO => 'Financeiro',
            self::CATEGORIA_ADMINISTRATIVO => 'Administrativo',
            self::CATEGORIA_LEGISLATIVO => 'Legislativo',
            self::CATEGORIA_RECURSOS_HUMANOS => 'Recursos Humanos',
            self::CATEGORIA_LICITACOES => 'Licitações',
            self::CATEGORIA_CONTRATOS => 'Contratos',
            self::CATEGORIA_TRANSPARENCIA => 'Transparência',
            self::CATEGORIA_OUTROS => 'Outros'
        ];
    }

    /**
     * Retorna as formas de recebimento disponíveis
     */
    public static function getFormasRecebimento()
    {
        return [
            self::FORMA_EMAIL => 'E-mail',
            self::FORMA_CORREIO => 'Correio',
            self::FORMA_PRESENCIAL => 'Presencial',
            self::FORMA_SISTEMA => 'Sistema'
        ];
    }

    /**
     * Retorna as opções de status disponíveis
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDENTE => 'Pendente',
            self::STATUS_EM_ANALISE => 'Em Análise',
            self::STATUS_AGUARDANDO_INFORMACOES => 'Aguardando Informações',
            self::STATUS_RESPONDIDA => 'Respondida',
            self::STATUS_NEGADA => 'Negada',
            self::STATUS_PARCIALMENTE_ATENDIDA => 'Parcialmente Atendida',
            self::STATUS_CANCELADA => 'Cancelada',
            self::STATUS_EXPIRADA => 'Expirada',
            self::STATUS_FINALIZADA => 'Finalizada'
        ];
    }
}
