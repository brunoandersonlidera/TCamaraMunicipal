<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:system.roles']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Role::query();

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('display_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('is_system')) {
            $query->where('is_system', $request->is_system);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $roles = $query->withCount('users')
                      ->orderBy('priority', 'desc')
                      ->orderBy('display_name')
                      ->paginate(15);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::active()
                                ->orderBy('module')
                                ->orderBy('priority')
                                ->get()
                                ->groupBy('module');

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
            'priority' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        DB::transaction(function () use ($request) {
            $role = Role::create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
                'color' => $request->color ?: '#6B7280',
                'priority' => $request->priority,
                'is_system' => false,
                'is_active' => $request->boolean('is_active', true),
                'guard_name' => 'web'
            ]);

            if ($request->filled('permissions')) {
                $permissions = Permission::whereIn('id', $request->permissions)->pluck('name');
                $role->givePermissionTo($permissions);
            }
        });

        return redirect()->route('admin.roles.index')
                        ->with('success', 'Tipo de usuário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->load(['permissions' => function($query) {
            $query->orderBy('module')->orderBy('priority');
        }, 'users']);

        $permissionsByModule = $role->permissions->groupBy('module');

        return view('admin.roles.show', compact('role', 'permissionsByModule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::active()
                                ->orderBy('module')
                                ->orderBy('priority')
                                ->get()
                                ->groupBy('module');

        $permissionsByModule = $permissions; // Alias para compatibilidade com a view
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'permissionsByModule', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
            'priority' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        DB::transaction(function () use ($request, $role) {
            $role->update([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
                'color' => $request->color ?: '#6B7280',
                'priority' => $request->priority,
                'is_active' => $request->boolean('is_active', true)
            ]);

            // Sincronizar permissões
            if ($request->filled('permissions')) {
                $permissions = Permission::whereIn('id', $request->permissions)->pluck('name');
                $role->syncPermissions($permissions);
            } else {
                $role->syncPermissions([]);
            }
        });

        return redirect()->route('admin.roles.index')
                        ->with('success', 'Tipo de usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (!$role->canBeDeleted()) {
            return redirect()->back()
                           ->with('error', 'Este tipo de usuário não pode ser excluído pois é um tipo do sistema ou possui usuários vinculados.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
                        ->with('success', 'Tipo de usuário excluído com sucesso!');
    }

    /**
     * Toggle role status
     */
    public function toggleStatus(Role $role)
    {
        $role->update(['is_active' => !$role->is_active]);

        $status = $role->is_active ? 'ativado' : 'desativado';
        
        return redirect()->back()
                        ->with('success', "Tipo de usuário {$status} com sucesso!");
    }
}
