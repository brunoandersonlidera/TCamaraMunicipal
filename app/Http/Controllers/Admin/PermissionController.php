<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:system.permissions']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Permission::query();

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('display_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('module', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%");
            });
        }

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('is_system')) {
            $query->where('is_system', $request->is_system);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $permissions = $query->withCount('roles')
                            ->orderBy('module')
                            ->orderBy('priority', 'desc')
                            ->orderBy('action')
                            ->paginate(20);

        // Para os filtros
        $modules = Permission::getAvailableModules();
        $actions = Permission::getAvailableActions();

        return view('admin.permissions.index', compact('permissions', 'modules', 'actions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = Permission::getAvailableModules();
        $actions = Permission::getAvailableActions();

        return view('admin.permissions.create', compact('modules', 'actions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'module' => 'required|string|max:100',
            'action' => 'required|string|max:100',
            'priority' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean'
        ]);

        Permission::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'module' => $request->module,
            'action' => $request->action,
            'priority' => $request->priority,
            'is_system' => false,
            'is_active' => $request->boolean('is_active', true),
            'guard_name' => 'web'
        ]);

        return redirect()->route('admin.permissions.index')
                        ->with('success', 'Permissão criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        $permission->load(['roles' => function($query) {
            $query->orderBy('priority', 'desc')->orderBy('display_name');
        }]);

        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        $modules = Permission::getAvailableModules();
        $actions = Permission::getAvailableActions();

        return view('admin.permissions.edit', compact('permission', 'modules', 'actions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission->id)],
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'module' => 'required|string|max:100',
            'action' => 'required|string|max:100',
            'priority' => 'required|integer|min:1|max:100',
            'is_active' => 'boolean'
        ]);

        $permission->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'module' => $request->module,
            'action' => $request->action,
            'priority' => $request->priority,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.permissions.index')
                        ->with('success', 'Permissão atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        if (!$permission->canBeDeleted()) {
            return redirect()->back()
                           ->with('error', 'Esta permissão não pode ser excluída pois é uma permissão do sistema ou está sendo utilizada por tipos de usuários.');
        }

        $permission->delete();

        return redirect()->route('admin.permissions.index')
                        ->with('success', 'Permissão excluída com sucesso!');
    }

    /**
     * Toggle permission status
     */
    public function toggleStatus(Permission $permission)
    {
        $permission->update(['is_active' => !$permission->is_active]);

        $status = $permission->is_active ? 'ativada' : 'desativada';
        
        return redirect()->back()
                        ->with('success', "Permissão {$status} com sucesso!");
    }

    /**
     * Get permissions by module (AJAX)
     */
    public function getByModule(Request $request)
    {
        $module = $request->get('module');
        
        $permissions = Permission::byModule($module)
                                ->active()
                                ->orderBy('priority', 'desc')
                                ->orderBy('action')
                                ->get(['id', 'name', 'display_name', 'action']);

        return response()->json($permissions);
    }
}
