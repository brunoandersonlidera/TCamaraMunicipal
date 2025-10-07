<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\ConfiguracaoGeral;
use App\Models\ComiteIniciativaPopular;
use App\Models\EsicSolicitacao;
use Illuminate\Support\Str;

class CidadaoAuthController extends Controller
{


    /**
     * Processar login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        
        // Tentar fazer login usando o guard cidadao
        if (Auth::guard('cidadao')->attempt($credentials, $request->filled('remember'))) {
            $cidadao = Auth::guard('cidadao')->user();
            
            // Verificar se o cidadão está ativo e tem a role correta
            if ($cidadao->role !== 'cidadao' || !$cidadao->active) {
                Auth::guard('cidadao')->logout();
                return back()->withErrors(['email' => 'Sua conta não está ativa ou não tem permissão para acessar esta área.'])->withInput();
            }
            
            $request->session()->regenerate();
            
            return redirect()->intended(route('cidadao.dashboard'));
        }

        return back()->withErrors(['email' => 'Credenciais inválidas.'])->withInput();
    }

    /**
     * Exibir formulário de registro
     */
    public function showRegistroForm()
    {
        $minimo_assinaturas = ConfiguracaoGeral::calcularMinimoAssinaturas();
        
        return view('cidadao.registro', compact('minimo_assinaturas'));
    }

    /**
     * Processar registro
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome_completo' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:users,cpf',
            'rg' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'data_nascimento' => 'required|date|before:today',
            'sexo' => 'nullable|in:M,F,O',
            'telefone' => 'nullable|string|max:20',
            'celular' => 'required|string|max:20',
            'cep' => 'required|string|size:8',
            'endereco' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|size:2',
            'titulo_eleitor' => 'required|string|size:12|unique:users,titulo_eleitor',
            'zona_eleitoral' => 'required|string|max:4',
            'secao_eleitoral' => 'required|string|max:4',
            'aceite_termos' => 'required|accepted',
            'aceite_lgpd' => 'required|accepted',
        ], [
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.size' => 'O CPF deve ter 11 dígitos.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'email.required' => 'O email é obrigatório.',
            'email.unique' => 'Este email já está cadastrado.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.before' => 'A data de nascimento deve ser anterior a hoje.',
            'celular.required' => 'O celular é obrigatório.',
            'cep.required' => 'O CEP é obrigatório.',
            'cep.size' => 'O CEP deve ter 8 dígitos.',
            'endereco.required' => 'O endereço é obrigatório.',
            'numero.required' => 'O número é obrigatório.',
            'bairro.required' => 'O bairro é obrigatório.',
            'cidade.required' => 'A cidade é obrigatória.',
            'estado.required' => 'O estado é obrigatório.',
            'estado.size' => 'O estado deve ter 2 caracteres.',
            'titulo_eleitor.required' => 'O título de eleitor é obrigatório.',
            'titulo_eleitor.size' => 'O título de eleitor deve ter 12 dígitos.',
            'titulo_eleitor.unique' => 'Este título de eleitor já está cadastrado.',
            'zona_eleitoral.required' => 'A zona eleitoral é obrigatória.',
            'secao_eleitoral.required' => 'A seção eleitoral é obrigatória.',
            'aceite_termos.accepted' => 'Você deve aceitar os termos de uso.',
            'aceite_lgpd.accepted' => 'Você deve aceitar a política de privacidade.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Criar usuário
        $user = \App\Models\User::create([
            'name' => $request->nome_completo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cidadao',
            'active' => true,
            'terms_accepted_at' => now(),
            'privacy_accepted_at' => now(),
            'cpf' => preg_replace('/\D/', '', $request->cpf),
            'rg' => $request->rg,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'telefone' => preg_replace('/\D/', '', $request->telefone),
            'celular' => preg_replace('/\D/', '', $request->celular),
            'cep' => preg_replace('/\D/', '', $request->cep),
            'endereco' => $request->endereco,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => strtoupper($request->estado),
            'titulo_eleitor' => preg_replace('/\D/', '', $request->titulo_eleitor),
            'zona_eleitoral' => $request->zona_eleitoral,
            'secao_eleitoral' => $request->secao_eleitoral,
            'status_verificacao' => 'pendente',
        ]);

        return redirect()->route('login')
            ->with('success', 'Cadastro realizado com sucesso! Sua conta será verificada pela administração em breve.');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::guard('cidadao')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')
            ->with('success', 'Logout realizado com sucesso!');
    }

    /**
     * Dashboard do cidadão
     */
    public function dashboard()
    {
        $user = Auth::guard('cidadao')->user();
        
        // Verificar se o usuário é um cidadão
        if (!$user || $user->role !== 'cidadao') {
            return redirect()->route('login')->with('error', 'Acesso não autorizado. Entre em contato com a administração.');
        }
        
        // Buscar estatísticas do cidadão
        $estatisticas = [
            'minhas_assinaturas' => $user->assinaturas()->count(),
            'meus_comites' => $user->comites()->count(),
            'projetos_disponiveis' => ComiteIniciativaPopular::ativo()->count(),
            'projetos_ativos' => ComiteIniciativaPopular::ativo()->where('data_fim_coleta', '>=', now())->count(),
        ];
        
        // Buscar comitês disponíveis para assinatura
        $comites_disponiveis = ComiteIniciativaPopular::ativo()
            ->where('data_fim_coleta', '>=', now())
            ->get();
        
        // Buscar meus comitês
        $meus_comites = $user->comites()->get();
        
        // Buscar mínimo de assinaturas
        $minimo_assinaturas = ConfiguracaoGeral::calcularMinimoAssinaturas();
        
        // Integração e-SIC: Buscar solicitações do usuário
        $minhasSolicitacoesEsic = \App\Models\EsicSolicitacao::where('email_solicitante', $user->email)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $estatisticasEsic = [
            'total_solicitacoes' => \App\Models\EsicSolicitacao::where('email_solicitante', $user->email)->count(),
            'pendentes' => \App\Models\EsicSolicitacao::where('email_solicitante', $user->email)->where('status', 'pendente')->count(),
            'respondidas' => \App\Models\EsicSolicitacao::where('email_solicitante', $user->email)->where('status', 'respondida')->count(),
            'em_analise' => \App\Models\EsicSolicitacao::where('email_solicitante', $user->email)->where('status', 'em_analise')->count()
        ];
        
        return view('cidadao.dashboard', compact(
            'user',
            'estatisticas', 
            'comites_disponiveis', 
            'meus_comites',
            'minimo_assinaturas',
            'minhasSolicitacoesEsic',
            'estatisticasEsic'
        ));
    }

    /**
     * Solicitar verificação automática da conta
     */
    public function solicitarVerificacao()
    {
        try {
            $user = Auth::guard('cidadao')->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado.'
                ], 401);
            }

            // Verificar se já está verificado
            if ($user->status_verificacao === 'verificado') {
                return response()->json([
                    'success' => false,
                    'message' => 'Sua conta já está verificada.'
                ]);
            }

            // Verificar se tem dados mínimos necessários
            $camposObrigatorios = ['name', 'email', 'cpf'];
            $camposFaltando = [];
            
            foreach ($camposObrigatorios as $campo) {
                if (empty($user->$campo)) {
                    $camposFaltando[] = $campo;
                }
            }

            if (!empty($camposFaltando)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Para verificar sua conta, você precisa completar os seguintes campos: ' . implode(', ', $camposFaltando) . '. Acesse seu perfil para atualizar essas informações.'
                ]);
            }

            // Verificar se o email está verificado
            if (!$user->email_verified_at) {
                return response()->json([
                    'success' => false,
                    'message' => 'Você precisa verificar seu email antes de solicitar a verificação da conta.'
                ]);
            }

            // Processar verificação automática
            $user->update([
                'status_verificacao' => 'verificado',
                'verificado_em' => now(),
                'verificado_por' => $user->id, // Auto-verificação
                'motivo_rejeicao' => null,
                'pode_assinar' => true,
                'pode_criar_comite' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sua conta foi verificada com sucesso! Agora você pode assinar projetos e criar comitês.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar verificação: ' . $e->getMessage()
            ], 500);
        }
    }
}
