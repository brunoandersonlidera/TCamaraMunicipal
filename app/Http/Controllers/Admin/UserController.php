<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query(); // Remover with('cidadao') pois não existe mais

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%"); // Buscar diretamente no User
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('active', $request->status === 'ativo');
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('is_active', true)->orderBy('priority', 'desc')->orderBy('name')->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Obter roles válidos para validação
        $validRoles = Role::where('is_active', true)->pluck('name')->toArray();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:' . implode(',', $validRoles),
            'active' => 'boolean',
            'cpf' => 'nullable|string|max:14',
            'telefone' => 'nullable|string|max:15',
            'cargo' => 'nullable|string|max:100',
            'setor' => 'nullable|string|max:100',
            'observacoes' => 'nullable|string|max:1000',
        ]);

        $validated['active'] = $request->has('active');
        $validated['email_verified_at'] = now();

        // Criar usuário com todos os dados incluindo role
        $userData = $validated;
        $user = User::create($userData);

        // Atribuir role usando Spatie Permission
        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Dados do cidadão agora estão diretamente no modelo User
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Dados do cidadão agora estão diretamente no modelo User
        $roles = Role::where('is_active', true)->orderBy('priority', 'desc')->orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Obter roles válidos para validação
        $validRoles = Role::where('is_active', true)->pluck('name')->toArray();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:' . implode(',', $validRoles),
            'active' => 'boolean',
            'data_nascimento' => 'nullable|date|before:today',
            'endereco' => 'nullable|string|max:500',
            'cpf' => 'nullable|string|max:14',
            'telefone' => 'nullable|string|max:15',
            'cargo' => 'nullable|string|max:100',
            'setor' => 'nullable|string|max:100',
            'observacoes' => 'nullable|string|max:1000',
            // Campos específicos do cidadão
            'nome_completo' => 'nullable|string|max:255',
            'rg' => 'nullable|string|max:20',
            'sexo' => 'nullable|in:M,F,Outro',
            'estado_civil' => 'nullable|string|max:50',
            'profissao' => 'nullable|string|max:255',
            'celular' => 'nullable|string|max:20',
            'cep' => 'nullable|string|max:10',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:10',
            'complemento' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'titulo_eleitor' => 'nullable|string|max:20',
            'zona_eleitoral' => 'nullable|string|max:10',
            'secao_eleitoral' => 'nullable|string|max:10',
        ]);

        $validated['active'] = $request->has('active');

        // Se não foi fornecida nova senha, remove do array
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        // Atualizar dados básicos do usuário
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'active' => $validated['active'],
            'role' => $validated['role'],
            'telefone' => $validated['telefone'] ?? null,
            'data_nascimento' => $validated['data_nascimento'] ?? null,
            'endereco' => $validated['endereco'] ?? null,
            'cargo' => $validated['cargo'] ?? null,
            'setor' => $validated['setor'] ?? null,
            'observacoes' => $validated['observacoes'] ?? null,
        ];
        
        // Adicionar senha se foi fornecida
        if (!empty($validated['password'])) {
            $userData['password'] = $validated['password'];
        }
        
        $user->update($userData);

        // Se for cidadão, atualizar dados específicos diretamente no usuário
        if ($validated['role'] === 'cidadao') {
            $cidadaoData = [
                'cpf' => $validated['cpf'] ?? null,
                'rg' => $validated['rg'] ?? null,
                'data_nascimento' => $validated['data_nascimento'] ?? null,
                'sexo' => $validated['sexo'] ?? null,
                'estado_civil' => $validated['estado_civil'] ?? null,
                'profissao' => $validated['profissao'] ?? null,
                'telefone' => $validated['telefone'] ?? null,
                'celular' => $validated['celular'] ?? null,
                'cep' => $validated['cep'] ?? null,
                'endereco' => $validated['endereco'] ?? null,
                'numero' => $validated['numero'] ?? null,
                'complemento' => $validated['complemento'] ?? null,
                'bairro' => $validated['bairro'] ?? null,
                'cidade' => $validated['cidade'] ?? null,
                'estado' => $validated['estado'] ?? null,
                'titulo_eleitor' => $validated['titulo_eleitor'] ?? null,
                'zona_eleitoral' => $validated['zona_eleitoral'] ?? null,
                'secao_eleitoral' => $validated['secao_eleitoral'] ?? null,
            ];
            
            // Atualizar os dados do cidadão diretamente no usuário
            $user->update($cidadaoData);
        }

        // Atualizar role usando Spatie Permission
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Não permitir excluir o próprio usuário
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Você não pode excluir seu próprio usuário!');
        }

        // Verificar se é o último admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Não é possível excluir o último administrador do sistema!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }

    /**
     * Toggle user status
     */
    public function toggleStatus(User $user)
    {
        // Não permitir desativar o próprio usuário
        if ($user->id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Você não pode desativar seu próprio usuário!'
            ], 400);
        }

        // Verificar se é o último admin ativo
        if ($user->role === 'admin' && $user->active && User::where('role', 'admin')->where('active', true)->count() <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Não é possível desativar o último administrador ativo!'
            ], 400);
        }

        $user->update(['active' => !$user->active]);

        return response()->json([
            'success' => true,
            'message' => 'Status do usuário alterado com sucesso!',
            'active' => $user->active
        ]);
    }

    /**
     * Reset user password
     */
    public function resetPassword(User $user)
    {
        // Gerar senha temporária
        $tempPassword = 'temp' . rand(1000, 9999);
        
        $user->update([
            'password' => $tempPassword, // O mutator do modelo já faz o hash
            'email_verified_at' => null // Forçar verificação de email
        ]);

        return redirect()->route('admin.users.show', $user)
            ->with('success', "Senha resetada! Nova senha temporária: {$tempPassword}")
            ->with('temp_password', $tempPassword);
    }

    /**
     * Impersonate user (login as)
     */
    public function impersonate(User $user)
    {
        if (!$user->active) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Não é possível fazer login como um usuário inativo!');
        }

        // Salvar o ID do admin original na sessão
        session(['impersonate_admin_id' => Auth::id()]);
        
        // Fazer login como o usuário
        Auth::login($user);

        // Redirecionar para a rota correta baseada no tipo de usuário
        $redirectRoute = match($user->role) {
            'admin' => 'admin.dashboard',
            'cidadao' => 'cidadao.dashboard',
            default => 'user.dashboard'
        };

        return redirect()->route($redirectRoute)
            ->with('success', "Agora você está logado como: {$user->name}");
    }

    /**
     * Stop impersonating
     */
    public function stopImpersonate()
    {
        $adminId = session('impersonate_admin_id');
        
        if ($adminId) {
            $admin = User::find($adminId);
            if ($admin) {
                Auth::login($admin);
                session()->forget('impersonate_admin_id');
                
                return redirect()->route('admin.users.index')
                    ->with('success', 'Você voltou ao seu usuário original.');
            }
        }

        return redirect()->route('login');
    }

    /**
     * Show form to manage user roles
     */
    public function manageRoles(User $user)
    {
        $roles = Role::where('is_active', true)->orderBy('priority')->get();
        $userRoles = $user->roles->pluck('id')->toArray();
        
        return view('admin.users.manage-roles', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update user roles
     */
    public function updateRoles(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ]);

        // Verificar se o usuário atual não está removendo seu próprio role de admin
        if ($user->id === Auth::id()) {
            $currentUserRoles = $user->roles->pluck('id')->toArray();
            $newRoles = $validated['roles'] ?? [];
            
            // Verificar se tem algum role de admin nos roles atuais
            $hasAdminRole = $user->roles->where('name', 'like', '%admin%')->count() > 0;
            
            if ($hasAdminRole) {
                // Verificar se ainda terá role de admin nos novos roles
                $newAdminRoles = Role::whereIn('id', $newRoles)
                    ->where('name', 'like', '%admin%')
                    ->count();
                
                if ($newAdminRoles === 0) {
                    return redirect()->back()
                        ->with('error', 'Você não pode remover seus próprios privilégios de administrador!');
                }
            }
        }

        // Sincronizar roles
        $user->syncRoles($validated['roles'] ?? []);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Roles do usuário atualizados com sucesso!');
    }

    /**
     * Get user permissions (via roles)
     */
    public function permissions(User $user)
    {
        $permissions = $user->getAllPermissions()->groupBy('module');
        
        return response()->json([
            'success' => true,
            'permissions' => $permissions
        ]);
    }

    /**
     * Verificar cidadão
     */
    public function verificarCidadao(User $user)
    {
        try {
            // Verificar se o usuário é um cidadão
            if ($user->role !== 'cidadao') {
                return response()->json([
                    'success' => false,
                    'message' => 'Este usuário não é um cidadão.'
                ], 400);
            }

            // Atualizar status de verificação
            $user->update([
                'status_verificacao' => 'verificado',
                'verificado_em' => now(),
                'verificado_por' => Auth::id(),
                'motivo_rejeicao' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cidadão verificado com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao verificar cidadão: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rejeitar cidadão
     */
    public function rejeitarCidadao(Request $request, User $user)
    {
        try {
            // Verificar se o usuário é um cidadão
            if ($user->role !== 'cidadao') {
                return response()->json([
                    'success' => false,
                    'message' => 'Este usuário não é um cidadão.'
                ], 400);
            }

            // Validar motivo (opcional)
            $validated = $request->validate([
                'motivo' => 'nullable|string|max:500'
            ]);

            // Atualizar status de verificação
            $user->update([
                'status_verificacao' => 'rejeitado',
                'verificado_em' => now(),
                'verificado_por' => Auth::id(),
                'motivo_rejeicao' => $validated['motivo'] ?? 'Não informado'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cidadão rejeitado com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao rejeitar cidadão: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle permission for citizen
     */
    public function togglePermission(Request $request, User $user)
    {
        try {
            // Verificar se o usuário é um cidadão
            if ($user->role !== 'cidadao') {
                return response()->json([
                    'success' => false,
                    'message' => 'Este usuário não é um cidadão.'
                ], 400);
            }

            // Validar dados
            $validated = $request->validate([
                'permission' => 'required|in:pode_assinar,pode_criar_comite',
                'enabled' => 'required|boolean'
            ]);

            // Atualizar permissão
            $user->update([
                $validated['permission'] => $validated['enabled']
            ]);

            $permissionName = $validated['permission'] === 'pode_assinar' ? 'assinatura' : 'criação de comitê';
            $action = $validated['enabled'] ? 'habilitada' : 'desabilitada';

            return response()->json([
                'success' => true,
                'message' => "Permissão de {$permissionName} {$action} com sucesso!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao alterar permissão: ' . $e->getMessage()
            ], 500);
        }
    }
}