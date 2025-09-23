<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class LicitacaoDocumento extends Model
{
    protected $table = 'licitacao_documentos';

    protected $fillable = [
        'licitacao_id',
        'nome',
        'descricao',
        'arquivo',
        'arquivo_original',
        'tipo_mime',
        'tamanho',
        'tipo_documento',
        'publico',
        'ordem'
    ];

    protected $casts = [
        'publico' => 'boolean',
        'tamanho' => 'integer',
        'ordem' => 'integer'
    ];

    /**
     * Relacionamento com Licitacao
     */
    public function licitacao(): BelongsTo
    {
        return $this->belongsTo(Licitacao::class);
    }

    /**
     * Tipos de documento disponíveis
     */
    public static function getTiposDocumento(): array
    {
        return [
            'edital' => 'Edital',
            'anexo_edital' => 'Anexo do Edital',
            'ata_abertura' => 'Ata de Abertura',
            'ata_julgamento' => 'Ata de Julgamento',
            'resultado' => 'Resultado',
            'contrato' => 'Contrato',
            'termo_referencia' => 'Termo de Referência',
            'projeto_basico' => 'Projeto Básico',
            'outros' => 'Outros'
        ];
    }

    /**
     * Retorna o nome do tipo de documento
     */
    public function getTipoDocumentoNomeAttribute(): string
    {
        $tipos = self::getTiposDocumento();
        return $tipos[$this->tipo_documento] ?? 'Outros';
    }

    /**
     * Retorna o tamanho formatado
     */
    public function getTamanhoFormatadoAttribute(): string
    {
        $bytes = $this->tamanho;
        
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Verifica se é um PDF
     */
    public function isPdf(): bool
    {
        return $this->tipo_mime === 'application/pdf';
    }

    /**
     * Verifica se é uma imagem
     */
    public function isImage(): bool
    {
        return str_starts_with($this->tipo_mime, 'image/');
    }

    /**
     * Retorna a URL para download
     */
    public function getDownloadUrlAttribute(): string
    {
        return route('transparencia.licitacoes.documento.download', [
            'licitacao' => $this->licitacao_id,
            'documento' => $this->id
        ]);
    }

    /**
     * Retorna a URL para visualização (PDFs)
     */
    public function getViewUrlAttribute(): string
    {
        return route('transparencia.licitacoes.documento.view', [
            'licitacao' => $this->licitacao_id,
            'documento' => $this->id
        ]);
    }

    /**
     * Scope para documentos públicos
     */
    public function scopePublicos($query)
    {
        return $query->where('publico', true);
    }

    /**
     * Scope para ordenar por ordem e nome
     */
    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem')->orderBy('nome');
    }
}
