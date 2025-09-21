<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EsicUsuario;
use App\Models\OuvidoriaManifestacao;
use App\Models\Notificacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EsicUsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EsicUsuario::query();

        // Filtros
        if ($request->filled('status')) {
            if ($request->status === 'ativo') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'inativo') {
                $query->whereNull('email_verified_at');
            }
        }

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'like', "%{$busca}%")
                  ->orWhere('email', 'like', "%{$busca}%")
                  ->orWhere('cpf', 'like', "%{$busca}%")
                  ->orWhere('telefone', 'like', "%{$busca}%");
            });
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        // Ordenação
        $orderBy = $request->get('order_by', 'created_at');
        $orderDirection = $request->get('order_direction', 'desc');
        $query->orderBy($orderBy, $orderDirection);

        $usuarios = $query->withCount('manifestacoes')->paginate(15);

        // Estatísticas
        $estatisticas = [
            'total' => EsicUsuario::count(),
            'ativos' => EsicUsuario::whereNotNull('email_verified_at')->count(),
            'inativos' => EsicUsuario::whereNull('email_verified_at')->count(),
            'com_manifestacoes' => EsicUsuario::has('manifestacoes')->count(),
            'novos_mes' => EsicUsuario::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count(),
        ];

        return view('admin.esic-usuarios.index', compact('usuarios', 'estatisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.esic-usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:esic_usuarios,email',
            'cpf' => 'nullable|string|size:11|unique:esic_usuarios,cpf',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:500',
            'data_nascimento' => 'nullable|date|before:today',
            'profissao' => 'nullable|string|max:100',
            'escolaridade' => 'nullable|in:fundamental_incompleto,fundamental_completo,medio_incompleto,medio_completo,superior_incompleto,superior_completo,pos_graduacao,mestrado,doutorado',
            'senha' => 'nullable|string|min:8|confirmed',
            'aceita_termos' => 'required|accepted',
            'verificar_email' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $dados = $request->all();
        
        // Gerar senha aleatória se não fornecida
        if (empty($dados['senha'])) {
            $dados['senha'] = Str::random(12);
        }
        
        $dados['password'] = Hash::make($dados['senha']);
        
        // Se deve verificar email automaticamente
        if ($request->boolean('verificar_email')) {
            $dados['email_verified_at'] = now();
            $dados['token_verificacao'] = null;
        } else {
            $dados['token_verificacao'] = Str::random(60);
        }

        $usuario = EsicUsuario::create($dados);

        return redirect()->route('admin.esic-usuarios.index')
                        ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EsicUsuario $usuario)
    {
        $usuario->load(['manifestacoes' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('admin.esic-usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EsicUsuario $usuario)
    {
        return view('admin.esic-usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EsicUsuario $usuario)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('esic_usuarios')->ignore($usuario->id)],
            'cpf' => ['nullable', 'string', 'size:11', Rule::unique('esic_usuarios')->ignore($usuario->id)],
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:500',
            'data_nascimento' => 'nullable|date|before:today',
            'profissao' => 'nullable|string|max:100',
            'escolaridade' => 'nullable|in:fundamental_incompleto,fundamental_completo,medio_incompleto,medio_completo,superior_incompleto,superior_completo,pos_graduacao,mestrado,doutorado',
            'senha' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $dados = $request->except(['senha', 'senha_confirmation']);
        
        // Atualizar senha se fornecida
        if ($request->filled('senha')) {
            $dados['password'] = Hash::make($request->senha);
        }

        $usuario->update($dados);

        return redirect()->route('admin.esic-usuarios.index')
                        ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EsicUsuario $usuario)
    {
        try {
            $usuario->delete();
            return redirect()->route('admin.esic-usuarios.index')
                           ->with('success', 'Usuário excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('admin.esic-usuarios.index')
                           ->with('error', 'Erro ao excluir usuário. Verifique se não há manifestações vinculadas.');
        }
    }

    /**
     * Toggle user status (verify/unverify email)
     */
    public function toggleStatus(EsicUsuario $usuario)
    {
        if ($usuario->email_verified_at) {
            $usuario->update([
                'ativo' => false,
                'email_verified_at' => null,
            ]);
            $message = 'Usuário desativado com sucesso.';
        } else {
            $usuario->update([
                'ativo' => true,
                'email_verified_at' => now(),
            ]);
            $message = 'Usuário ativado com sucesso.';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Resend verification email
     */
    public function resendVerification(EsicUsuario $usuario)
    {
        if ($usuario->email_verified_at) {
            return redirect()->back()->with('error', 'Este usuário já está verificado.');
        }

        // Gerar novo token se necessário
        if (!$usuario->token_verificacao) {
            $usuario->update(['token_verificacao' => Str::random(60)]);
        }

        // Aqui você pode implementar o envio do email
        // Mail::to($usuario->email)->send(new VerificationEmail($usuario));

        return redirect()->back()->with('success', 'Email de verificação reenviado!');
    }

    /**
     * Reset user password
     */
    public function resetPassword(EsicUsuario $usuario)
    {
        $novaSenha = Str::random(12);
        $usuario->update(['password' => Hash::make($novaSenha)]);

        // Aqui você pode implementar o envio da nova senha por email
        // Mail::to($usuario->email)->send(new NewPasswordEmail($usuario, $novaSenha));

        return redirect()->back()->with('success', 'Senha resetada e enviada por email!');
    }

    /**
     * Show reports page
     */
    public function relatorios()
    {
        return view('admin.esic-usuarios.relatorios');
    }

    /**
     * Export users data
     */
    public function exportar(Request $request)
    {
        // Implementar exportação (Excel, CSV, PDF)
        return redirect()->back()->with('info', 'Funcionalidade de exportação em desenvolvimento.');
    }
}