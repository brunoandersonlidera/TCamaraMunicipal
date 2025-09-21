<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Menu extends Model
{
    protected $fillable = [
        'titulo',
        'slug',
        'url',
        'rota',
        'icone',
        'posicao',
        'tipo',
        'parent_id',
        'ordem',
        'ativo',
        'nova_aba',
        'permissao',
        'descricao',
        'configuracoes'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'nova_aba' => 'boolean',
        'configuracoes' => 'array',
        'ordem' => 'integer'
    ];

    // Relacionamentos
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('ordem');
    }

    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    // Scopes
    public function scopeAtivos(Builder $query): Builder
    {
        return $query->where('ativo', true);
    }

    public function scopeHeader(Builder $query): Builder
    {
        return $query->whereIn('posicao', ['header', 'ambos']);
    }

    public function scopeFooter(Builder $query): Builder
    {
        return $query->whereIn('posicao', ['footer', 'ambos']);
    }

    public function scopePrincipais(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdenados(Builder $query): Builder
    {
        return $query->orderBy('ordem');
    }

    // Métodos auxiliares
    public function getUrlCompleta(): string
    {
        if ($this->rota) {
            try {
                return route($this->rota);
            } catch (\Exception $e) {
                return $this->url ?? '#';
            }
        }
        
        return $this->url ?? '#';
    }

    public function temFilhos(): bool
    {
        return $this->children()->exists();
    }

    public function isDropdown(): bool
    {
        return $this->tipo === 'dropdown' || $this->temFilhos();
    }

    public function getGrupoFooterAttribute(): ?string
    {
        $configuracoes = $this->configuracoes;
        if (is_string($configuracoes)) {
            $configuracoes = json_decode($configuracoes, true);
        }
        
        return $configuracoes['grupo_footer'] ?? null;
    }

    public function isDivider(): bool
    {
        return $this->tipo === 'divider';
    }

    public function podeExibir(): bool
    {
        if (!$this->ativo) {
            return false;
        }

        if ($this->permissao && auth()->check()) {
            return auth()->user()->can($this->permissao);
        }

        return true;
    }

    // Métodos estáticos para buscar menus
    public static function getMenusHeader(): \Illuminate\Database\Eloquent\Collection
    {
        return static::ativos()
            ->header()
            ->principais()
            ->ordenados()
            ->with(['childrenRecursive' => function ($query) {
                $query->ativos()->ordenados();
            }])
            ->get();
    }

    public static function getMenusFooter(): \Illuminate\Database\Eloquent\Collection
    {
        return static::ativos()
            ->footer()
            ->principais()
            ->ordenados()
            ->with(['childrenRecursive' => function ($query) {
                $query->ativos()->ordenados();
            }])
            ->get();
    }

    // Boot method para auto-gerar slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($menu) {
            if (!$menu->slug) {
                $menu->slug = \Str::slug($menu->titulo);
            }
        });

        static::updating(function ($menu) {
            if ($menu->isDirty('titulo') && !$menu->isDirty('slug')) {
                $menu->slug = \Str::slug($menu->titulo);
            }
        });
    }
}
