<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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

        // Validações básicas para todos os usuários
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'address' => 'required|string|max:500',
            'cargo' => 'nullable|string|max:255',
            'setor' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string|max:1000',
        ];

        // Adicionar validações específicas para cidadãos
        if ($user->role === 'cidadao') {
            $rules = array_merge($rules, [
                'cpf' => [
                    'required',
                    'string',
                    'size:14',
                    Rule::unique('users', 'cpf')->ignore($user->id)
                ],
                'rg' => 'nullable|string|max:20',
                'sexo' => 'nullable|in:M,F,O',
                'estado_civil' => 'nullable|in:solteiro,casado,divorciado,viuvo,uniao_estavel',
                'profissao' => 'nullable|string|max:255',
                'telefone_fixo' => 'nullable|string|max:20',
                'celular' => 'nullable|string|max:20',
                'cep' => 'nullable|string|max:10',
                'endereco_detalhado' => 'nullable|string|max:255',
                'numero' => 'nullable|string|max:10',
                'complemento' => 'nullable|string|max:100',
                'bairro' => 'nullable|string|max:100',
                'cidade' => 'nullable|string|max:100',
                'estado' => 'nullable|string|size:2',
                'titulo_eleitor' => 'nullable|string|max:20',
                'zona_eleitoral' => 'nullable|string|max:10',
                'secao_eleitoral' => 'nullable|string|max:10',
            ]);
        }

        $messages = [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ter um formato válido.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
            'email.unique' => 'Este e-mail já está sendo usado por outro usuário.',
            'phone.required' => 'O telefone é obrigatório.',
            'phone.max' => 'O telefone não pode ter mais de 20 caracteres.',
            'birth_date.required' => 'A data de nascimento é obrigatória.',
            'birth_date.date' => 'A data de nascimento deve ser uma data válida.',
            'address.required' => 'O endereço é obrigatório.',
            'address.max' => 'O endereço não pode ter mais de 500 caracteres.',
            'cargo.max' => 'O cargo não pode ter mais de 255 caracteres.',
            'setor.max' => 'O setor não pode ter mais de 255 caracteres.',
            'observacoes.max' => 'As observações não podem ter mais de 1000 caracteres.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.size' => 'O CPF deve ter exatamente 14 caracteres (formato: 000.000.000-00).',
            'cpf.unique' => 'Este CPF já está cadastrado no sistema.',
        ];

        // Validação adicional para cidadãos (apenas campos que ainda existem)
        if ($user->role === 'cidadao') {
            // Não há campos adicionais específicos para validar, 
            // pois agora usamos campos unificados
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Atualiza dados na tabela users
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'cargo' => $request->cargo,
            'setor' => $request->setor,
            'observacoes' => $request->observacoes,
        ]);

        // Atualizar dados específicos do cidadão se aplicável
        if ($user->role === 'cidadao') {
            // Dados específicos do cidadão para atualizar diretamente no usuário
            $cidadaoData = [];
            
            // Adicionar campos específicos do cidadão se fornecidos
            if ($request->has('cpf')) $cidadaoData['cpf'] = $request->cpf;
            if ($request->has('rg')) $cidadaoData['rg'] = $request->rg;
            if ($request->has('sexo')) $cidadaoData['sexo'] = $request->sexo;
            if ($request->has('estado_civil')) $cidadaoData['estado_civil'] = $request->estado_civil;
            if ($request->has('profissao')) $cidadaoData['profissao'] = $request->profissao;
            if ($request->has('telefone_fixo')) $cidadaoData['telefone'] = $request->telefone_fixo;
            if ($request->has('celular')) $cidadaoData['celular'] = $request->celular;
            if ($request->has('cep')) $cidadaoData['cep'] = $request->cep;
            if ($request->has('endereco_detalhado')) $cidadaoData['endereco'] = $request->endereco_detalhado;
            if ($request->has('numero')) $cidadaoData['numero'] = $request->numero;
            if ($request->has('complemento')) $cidadaoData['complemento'] = $request->complemento;
            if ($request->has('bairro')) $cidadaoData['bairro'] = $request->bairro;
            if ($request->has('cidade')) $cidadaoData['cidade'] = $request->cidade;
            if ($request->has('estado')) $cidadaoData['estado'] = $request->estado;
            if ($request->has('titulo_eleitor')) $cidadaoData['titulo_eleitor'] = $request->titulo_eleitor;
            if ($request->has('zona_eleitoral')) $cidadaoData['zona_eleitoral'] = $request->zona_eleitoral;
            if ($request->has('secao_eleitoral')) $cidadaoData['secao_eleitoral'] = $request->secao_eleitoral;
            
            // Atualizar os dados do cidadão diretamente no usuário
            if (!empty($cidadaoData)) {
                $user->update($cidadaoData);
            }
        }

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