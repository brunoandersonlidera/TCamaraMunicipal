<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class ManifestacaoAnexo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'manifestacao_anexos';

    protected $fillable = [
        'manifestacao_id',
        'usuario_id',
        'nome_original',
        'nome_arquivo',
        'caminho_arquivo',
        'tamanho_bytes',
        'tipo_mime',
        'extensao',
        'tipo_anexo',
        'hash_arquivo',
        'publico',
        'descricao',
        'ip_upload'
    ];

    protected $casts = [
        'tamanho_bytes' => 'integer',
        'publico' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relacionamentos
    public function manifestacao()
    {
        return $this->belongsTo(OuvidoriaManifestacao::class, 'manifestacao_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Accessors
    public function getUrlAttribute()
    {
        if ($this->publico) {
            return Storage::url($this->caminho_arquivo);
        }
        return route('anexo.download', $this->id);
    }

    public function getTamanhoFormatadoAttribute()
    {
        $bytes = $this->tamanho_bytes;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getExtensaoAttribute()
    {
        return pathinfo($this->nome_original, PATHINFO_EXTENSION);
    }

    public function getEImagemAttribute()
    {
        $extensoesImagem = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
        return in_array(strtolower($this->extensao), $extensoesImagem);
    }

    // Scopes
    public function scopePublicos($query)
    {
        return $query->where('publico', true);
    }

    public function scopePrivados($query)
    {
        return $query->where('publico', false);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_mime', 'like', $tipo . '%');
    }

    public function scopeImagens($query)
    {
        return $query->where('tipo_mime', 'like', 'image/%');
    }

    public function scopeDocumentos($query)
    {
        return $query->whereIn('tipo_mime', [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
    }

    // Métodos auxiliares
    public function podeSerVisualizadoPor($usuario)
    {
        if ($this->publico) {
            return true;
        }

        // Proprietário do anexo
        if ($this->usuario_id === $usuario->id) {
            return true;
        }

        // Ouvidor responsável pela manifestação
        if ($usuario instanceof \App\Models\User && $usuario->role === 'ouvidor') {
            return $this->manifestacao->ouvidor_responsavel_id === $usuario->id;
        }

        return false;
    }

    public function excluir()
    {
        // Remove o arquivo físico
        if (Storage::exists($this->caminho_arquivo)) {
            Storage::delete($this->caminho_arquivo);
        }

        // Soft delete do registro
        return $this->delete();
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($anexo) {
            // Remove arquivo físico quando deletado permanentemente
            if ($anexo->isForceDeleting() && Storage::exists($anexo->caminho_arquivo)) {
                Storage::delete($anexo->caminho_arquivo);
            }
        });
    }
}
