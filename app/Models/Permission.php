<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Database\Eloquent\Builder;

class Permission extends SpatiePermission
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
        'module',
        'action',
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
     * Scope para permissões ativas
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para permissões do sistema
     */
    public function scopeSystem(Builder $query): Builder
    {
        return $query->where('is_system', true);
    }

    /**
     * Scope para permissões personalizadas
     */
    public function scopeCustom(Builder $query): Builder
    {
        return $query->where('is_system', false);
    }

    /**
     * Scope para filtrar por módulo
     */
    public function scopeByModule(Builder $query, string $module): Builder
    {
        return $query->where('module', $module);
    }

    /**
     * Scope para filtrar por ação
     */
    public function scopeByAction(Builder $query, string $action): Builder
    {
        return $query->where('action', $action);
    }

    /**
     * Scope para ordenar por módulo e prioridade
     */
    public function scopeByModuleAndPriority(Builder $query): Builder
    {
        return $query->orderBy('module')
                    ->orderBy('priority', 'desc')
                    ->orderBy('display_name');
    }

    /**
     * Verifica se a permissão pode ser excluída
     */
    public function canBeDeleted(): bool
    {
        return !$this->is_system && $this->roles()->count() === 0;
    }

    /**
     * Retorna o nome para exibição
     */
    public function getDisplayNameAttribute($value): string
    {
        return $value ?: $this->name;
    }

    /**
     * Retorna permissões agrupadas por módulo
     */
    public static function getPermissionsByModule()
    {
        return static::active()
            ->byModuleAndPriority()
            ->get()
            ->groupBy('module')
            ->map(function ($permissions, $module) {
                return [
                    'module' => $module ?: 'Geral',
                    'permissions' => $permissions->map(function ($permission) {
                        return [
                            'id' => $permission->id,
                            'name' => $permission->name,
                            'display_name' => $permission->display_name,
                            'description' => $permission->description,
                            'action' => $permission->action,
                            'is_system' => $permission->is_system,
                        ];
                    })
                ];
            })
            ->values();
    }

    /**
     * Retorna as ações disponíveis
     */
    public static function getAvailableActions(): array
    {
        return [
            'view' => 'Visualizar',
            'create' => 'Criar',
            'edit' => 'Editar',
            'delete' => 'Excluir',
            'manage' => 'Gerenciar',
            'publish' => 'Publicar',
            'approve' => 'Aprovar',
        ];
    }

    /**
     * Retorna os módulos disponíveis
     */
    public static function getAvailableModules(): array
    {
        return [
            'noticias' => 'Notícias',
            'usuarios' => 'Usuários',
            'esic' => 'e-SIC',
            'ouvidoria' => 'Ouvidoria',
            'legislacao' => 'Legislação',
            'transparencia' => 'Transparência',
            'sessoes' => 'Sessões',
            'vereadores' => 'Vereadores',
            'admin' => 'Administração',
            'sistema' => 'Sistema',
        ];
    }
}
