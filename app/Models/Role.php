<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Builder;

class Role extends SpatieRole
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'color',
        'is_system',
        'is_active',
        'priority',
        'guard_name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_system' => 'boolean',
        'is_active' => 'boolean',
        'priority' => 'integer',
    ];

    /**
     * Scope para roles ativos
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para roles do sistema
     */
    public function scopeSystem(Builder $query): Builder
    {
        return $query->where('is_system', true);
    }

    /**
     * Scope para roles personalizados (não do sistema)
     */
    public function scopeCustom(Builder $query): Builder
    {
        return $query->where('is_system', false);
    }

    /**
     * Scope para ordenar por prioridade
     */
    public function scopeByPriority(Builder $query): Builder
    {
        return $query->orderBy('priority', 'desc')->orderBy('display_name');
    }

    /**
     * Verifica se o role pode ser excluído
     */
    public function canBeDeleted(): bool
    {
        return !$this->is_system && $this->users()->count() === 0;
    }

    /**
     * Retorna o nome para exibição
     */
    public function getDisplayNameAttribute($value): string
    {
        return $value ?: $this->name;
    }

    /**
     * Retorna a cor com fallback
     */
    public function getColorAttribute($value): string
    {
        return $value ?: '#6B7280';
    }

    /**
     * Retorna roles disponíveis para seleção
     */
    public static function getAvailableRoles()
    {
        return static::active()
            ->byPriority()
            ->get()
            ->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'display_name' => $role->display_name,
                    'description' => $role->description,
                    'color' => $role->color,
                    'is_system' => $role->is_system,
                ];
            });
    }
}
