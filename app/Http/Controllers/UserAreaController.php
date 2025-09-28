<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserAreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Exibe o dashboard do usuário
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Estatísticas do usuário
        $stats = [
            'total_solicitacoes' => 0, // Implementar quando houver sistema de solicitações
            'solicitacoes_pendentes' => 0,
            'solicitacoes_resolvidas' => 0,
            'ultima_atividade' => $user->updated_at,
        ];

        return view('user.dashboard', compact('user', 'stats'));
    }

    /**
     * Exibe o perfil do usuário
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Atualiza o perfil do usuário
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date|before:today',
            'address' => 'nullable|string|max:500',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'email.unique' => 'Este email já está sendo usado por outro usuário.',
            'phone.max' => 'O telefone não pode ter mais de 20 caracteres.',
            'birth_date.date' => 'Por favor, insira uma data válida.',
            'birth_date.before' => 'A data de nascimento deve ser anterior a hoje.',
            'address.max' => 'O endereço não pode ter mais de 500 caracteres.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Exibe o formulário de alteração de senha
     */
    public function showChangePassword()
    {
        return view('user.change-password');
    }

    /**
     * Atualiza a senha do usuário
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'A senha atual é obrigatória.',
            'password.required' => 'A nova senha é obrigatória.',
            'password.min' => 'A nova senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da nova senha não confere.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user = Auth::user();

        // Verifica se a senha atual está correta
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'A senha atual está incorreta.']);
        }

        // Atualiza a senha
        $user->update([
            'password' => $request->password // O mutator do modelo já faz o hash
        ]);

        return back()->with('success', 'Senha alterada com sucesso!');
    }

    /**
     * Exibe o histórico de atividades do usuário
     */
    public function history()
    {
        $user = Auth::user();
        
        // Aqui você pode implementar um sistema de logs de atividades
        $activities = collect([
            [
                'type' => 'login',
                'description' => 'Login realizado',
                'date' => now()->subDays(1),
                'icon' => 'fas fa-sign-in-alt',
                'color' => 'success'
            ],
            [
                'type' => 'profile_update',
                'description' => 'Perfil atualizado',
                'date' => now()->subDays(3),
                'icon' => 'fas fa-user-edit',
                'color' => 'info'
            ],
            [
                'type' => 'password_change',
                'description' => 'Senha alterada',
                'date' => now()->subWeeks(1),
                'icon' => 'fas fa-key',
                'color' => 'warning'
            ],
        ]);

        return view('user.history', compact('user', 'activities'));
    }

    /**
     * Exibe as notificações do usuário
     */
    public function notifications()
    {
        $user = Auth::user();
        
        // Exemplo de notificações - implementar sistema real posteriormente
        $notifications = collect([
            [
                'id' => 1,
                'title' => 'Bem-vindo ao sistema!',
                'message' => 'Sua conta foi criada com sucesso. Explore todas as funcionalidades disponíveis.',
                'type' => 'welcome',
                'read' => false,
                'created_at' => now()->subHours(2),
                'icon' => 'fas fa-hand-wave',
                'color' => 'primary'
            ],
            [
                'id' => 2,
                'title' => 'Perfil verificado',
                'message' => 'Seu email foi verificado com sucesso.',
                'type' => 'verification',
                'read' => true,
                'created_at' => now()->subDays(1),
                'icon' => 'fas fa-check-circle',
                'color' => 'success'
            ],
        ]);

        return view('user.notifications', compact('user', 'notifications'));
    }

    /**
     * Marca notificação como lida
     */
    public function markNotificationAsRead($id)
    {
        // Implementar quando houver sistema de notificações real
        return response()->json(['success' => true]);
    }

    /**
     * Exibe as configurações do usuário
     */
    public function settings()
    {
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }

    /**
     * Atualiza as configurações do usuário
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'newsletter' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        // Aqui você pode salvar as preferências em uma tabela separada
        // Por enquanto, vamos simular que foi salvo
        
        return back()->with('success', 'Configurações atualizadas com sucesso!');
    }
}