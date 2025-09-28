<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ContratoFiscalizacao extends Model
{
    protected $fillable = [
        'contrato_id',
        'numero_relatorio',
        'data_fiscalizacao',
        'data_fim_vigencia',
        'fiscal_responsavel',
        'numero_portaria',
        'data_portaria',
        'tipo_fiscalizacao',
        'objeto_fiscalizacao',
        'observacoes_encontradas',
        'status_execucao',
        'recomendacoes',
        'providencias_adotadas',
        'prazo_regularizacao',
        'status_regularizacao',
        'arquivo_relatorio',
        'arquivo_relatorio_original',
        'arquivo_pdf',
        'arquivo_pdf_original',
        'publico'
    ];

    protected $casts = [
        'data_fiscalizacao' => 'date',
        'data_fim_vigencia' => 'date',
        'data_portaria' => 'date',
        'prazo_regularizacao' => 'date',
        'publico' => 'boolean'
    ];

    /**
     * Relacionamento com contrato
     */
    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    /**
     * Scope para fiscalizações públicas
     */
    public function scopePublicos($query)
    {
        return $query->where('publico', true);
    }

    /**
     * Scope para tipo específico
     */
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo_fiscalizacao', $tipo);
    }

    /**
     * Scope para status específico
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status_execucao', $status);
    }

    /**
     * URL do arquivo do relatório
     */
    public function getArquivoUrlAttribute()
    {
        if ($this->arquivo_relatorio) {
            return Storage::url('contratos/fiscalizacoes/' . $this->arquivo_relatorio);
        }
        return null;
    }

    /**
     * Verifica se tem arquivo
     */
    public function getTemArquivoAttribute()
    {
        return !empty($this->arquivo_relatorio) && Storage::exists('contratos/fiscalizacoes/' . $this->arquivo_relatorio);
    }

    /**
     * Retorna o tipo formatado
     */
    public function getTipoFormatadoAttribute()
    {
        $tipos = [
            'rotina' => 'Fiscalização de Rotina',
            'especial' => 'Fiscalização Especial',
            'denuncia' => 'Fiscalização por Denúncia',
            'auditoria' => 'Auditoria'
        ];

        return $tipos[$this->tipo_fiscalizacao] ?? $this->tipo_fiscalizacao;
    }

    /**
     * Retorna o status formatado
     */
    public function getStatusFormatadoAttribute()
    {
        $status = [
            'conforme' => 'Conforme',
            'nao_conforme' => 'Não Conforme',
            'parcialmente_conforme' => 'Parcialmente Conforme'
        ];

        return $status[$this->status_execucao] ?? $this->status_execucao;
    }

    /**
     * Retorna o status de regularização formatado
     */
    public function getStatusRegularizacaoFormatadoAttribute()
    {
        $status = [
            'pendente' => 'Pendente',
            'em_andamento' => 'Em Andamento',
            'regularizado' => 'Regularizado',
            'nao_aplicavel' => 'Não Aplicável'
        ];

        return $status[$this->status_regularizacao] ?? $this->status_regularizacao;
    }

    /**
     * URL do arquivo PDF
     */
    public function getArquivoPdfUrlAttribute()
    {
        if ($this->arquivo_pdf) {
            return Storage::disk('public')->url('contratos/fiscalizacoes/pdfs/' . $this->arquivo_pdf);
        }
        return null;
    }

    /**
     * Verifica se tem arquivo PDF
     */
    public function getTemArquivoPdfAttribute()
    {
        return !empty($this->arquivo_pdf) && Storage::disk('public')->exists('contratos/fiscalizacoes/pdfs/' . $this->arquivo_pdf);
    }

    /**
     * URL pública do PDF (para acesso público)
     */
    public function getArquivoPdfPublicoUrlAttribute()
    {
        if ($this->arquivo_pdf && $this->publico) {
            return route('contratos.fiscalizacoes.pdf.publico', [$this->contrato_id, $this->id]);
        }
        return null;
    }
}
