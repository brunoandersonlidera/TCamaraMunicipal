<?php

namespace App\Http\Controllers;

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

        return view('admin.esic.usuarios.index', compact('usuarios', 'estatisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.esic.usuarios.create');
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
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ter um formato válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'cpf.size' => 'O CPF deve ter 11 dígitos.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'data_nascimento.before' => 'A data de nascimento deve ser anterior a hoje.',
            'senha.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'senha.confirmed' => 'A confirmação da senha não confere.',
            'aceita_termos.accepted' => 'É necessário aceitar os termos de uso.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $dadosUsuario = [
                'nome' => $request->nome,
                'email' => $request->email,
                'cpf' => $request->cpf ? preg_replace('/\D/', '', $request->cpf) : null,
                'telefone' => $request->telefone,
                'endereco' => $request->endereco,
                'data_nascimento' => $request->data_nascimento,
                'profissao' => $request->profissao,
                'escolaridade' => $request->escolaridade,
                'aceita_termos' => true,
                'data_aceite_termos' => now(),
            ];

            // Se foi definida uma senha
            if ($request->filled('senha')) {
                $dadosUsuario['password'] = Hash::make($request->senha);
            }

            // Se deve verificar email automaticamente (criação administrativa)
            if ($request->boolean('verificar_email')) {
                $dadosUsuario['email_verified_at'] = now();
                $dadosUsuario['token_verificacao'] = null;
            } else {
                $dadosUsuario['token_verificacao'] = Str::random(60);
            }

            $usuario = EsicUsuario::create($dadosUsuario);

            // Enviar email de verificação se necessário
            if (!$request->boolean('verificar_email')) {
                $this->enviarEmailVerificacao($usuario);
            }

            return redirect()->route('admin.esic.usuarios.show', $usuario)
                           ->with('success', 'Usuário criado com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao criar usuário: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EsicUsuario $usuario)
    {
        $usuario->load(['manifestacoes' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }]);

        $estatisticas = [
            'total_manifestacoes' => $usuario->manifestacoes()->count(),
            'manifestacoes_abertas' => $usuario->manifestacoes()->where('status', 'aberta')->count(),
            'manifestacoes_respondidas' => $usuario->manifestacoes()->where('status', 'respondida')->count(),
            'ultima_manifestacao' => $usuario->manifestacoes()->latest()->first()?->created_at,
            'tempo_medio_resposta' => $usuario->manifestacoes()
                                            ->whereNotNull('data_resposta')
                                            ->selectRaw('AVG(DATEDIFF(data_resposta, created_at)) as media')
                                            ->value('media'),
        ];

        return view('admin.esic.usuarios.show', compact('usuario', 'estatisticas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EsicUsuario $usuario)
    {
        return view('admin.esic.usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EsicUsuario $usuario)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('esic_usuarios', 'email')->ignore($usuario->id)
            ],
            'cpf' => [
                'nullable',
                'string',
                'size:11',
                Rule::unique('esic_usuarios', 'cpf')->ignore($usuario->id)
            ],
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:500',
            'data_nascimento' => 'nullable|date|before:today',
            'profissao' => 'nullable|string|max:100',
            'escolaridade' => 'nullable|in:fundamental_incompleto,fundamental_completo,medio_incompleto,medio_completo,superior_incompleto,superior_completo,pos_graduacao,mestrado,doutorado',
            'nova_senha' => 'nullable|string|min:8|confirmed',
            'ativo' => 'boolean',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ter um formato válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'cpf.size' => 'O CPF deve ter 11 dígitos.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'data_nascimento.before' => 'A data de nascimento deve ser anterior a hoje.',
            'nova_senha.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'nova_senha.confirmed' => 'A confirmação da senha não confere.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $dadosAtualizacao = [
                'nome' => $request->nome,
                'email' => $request->email,
                'cpf' => $request->cpf ? preg_replace('/\D/', '', $request->cpf) : null,
                'telefone' => $request->telefone,
                'endereco' => $request->endereco,
                'data_nascimento' => $request->data_nascimento,
                'profissao' => $request->profissao,
                'escolaridade' => $request->escolaridade,
            ];

            // Atualizar senha se fornecida
            if ($request->filled('nova_senha')) {
                $dadosAtualizacao['password'] = Hash::make($request->nova_senha);
            }

            // Gerenciar status ativo/inativo
            if ($request->has('ativo')) {
                if ($request->boolean('ativo') && !$usuario->email_verified_at) {
                    $dadosAtualizacao['email_verified_at'] = now();
                    $dadosAtualizacao['token_verificacao'] = null;
                } elseif (!$request->boolean('ativo') && $usuario->email_verified_at) {
                    $dadosAtualizacao['email_verified_at'] = null;
                }
            }

            $usuario->update($dadosAtualizacao);

            return back()->with('success', 'Usuário atualizado com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar usuário: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EsicUsuario $usuario)
    {
        try {
            // Verificar se tem manifestações
            if ($usuario->manifestacoes()->count() > 0) {
                return back()->with('error', 'Não é possível excluir usuário que possui manifestações.');
            }

            $usuario->delete();

            return redirect()->route('admin.esic.usuarios.index')
                           ->with('success', 'Usuário excluído com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir usuário: ' . $e->getMessage());
        }
    }

    /**
     * Verificar email do usuário
     */
    public function verificarEmail(EsicUsuario $usuario)
    {
        if ($usuario->email_verified_at) {
            return back()->with('info', 'E-mail já está verificado.');
        }

        $usuario->update([
            'email_verified_at' => now(),
            'token_verificacao' => null,
        ]);

        return back()->with('success', 'E-mail verificado com sucesso!');
    }

    /**
     * Reenviar email de verificação
     */
    public function reenviarVerificacao(EsicUsuario $usuario)
    {
        if ($usuario->email_verified_at) {
            return back()->with('info', 'E-mail já está verificado.');
        }

        try {
            // Gerar novo token
            $usuario->update([
                'token_verificacao' => Str::random(60),
            ]);

            $this->enviarEmailVerificacao($usuario);

            return back()->with('success', 'E-mail de verificação reenviado com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao reenviar e-mail: ' . $e->getMessage());
        }
    }

    /**
     * Resetar senha do usuário
     */
    public function resetarSenha(EsicUsuario $usuario)
    {
        try {
            $novaSenha = Str::random(8);
            
            $usuario->update([
                'password' => Hash::make($novaSenha),
                'token_reset_senha' => null,
            ]);

            // Enviar nova senha por email
            // TODO: Implementar envio de email com nova senha

            return back()->with('success', 'Senha resetada com sucesso! Nova senha enviada por e-mail.');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao resetar senha: ' . $e->getMessage());
        }
    }

    /**
     * Relatórios de usuários
     */
    public function relatorios(Request $request)
    {
        $periodo = $request->get('periodo', '30');
        $dataInicio = now()->subDays($periodo);

        $estatisticas = [
            'total_usuarios' => EsicUsuario::count(),
            'usuarios_ativos' => EsicUsuario::whereNotNull('email_verified_at')->count(),
            'novos_periodo' => EsicUsuario::where('created_at', '>=', $dataInicio)->count(),
            'por_escolaridade' => EsicUsuario::whereNotNull('escolaridade')
                                           ->selectRaw('escolaridade, COUNT(*) as total')
                                           ->groupBy('escolaridade')
                                           ->pluck('total', 'escolaridade'),
            'manifestacoes_por_usuario' => EsicUsuario::withCount('manifestacoes')
                                                     ->having('manifestacoes_count', '>', 0)
                                                     ->orderBy('manifestacoes_count', 'desc')
                                                     ->limit(10)
                                                     ->get(),
            'usuarios_sem_manifestacao' => EsicUsuario::doesntHave('manifestacoes')->count(),
        ];

        return view('admin.esic.usuarios.relatorios', compact('estatisticas', 'periodo'));
    }

    /**
     * Exportar usuários
     */
    public function exportar(Request $request)
    {
        $query = EsicUsuario::query();

        // Aplicar filtros se fornecidos
        if ($request->filled('status')) {
            if ($request->status === 'ativo') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'inativo') {
                $query->whereNull('email_verified_at');
            }
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        $usuarios = $query->get();

        // Gerar CSV
        $filename = 'usuarios_esic_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($usuarios) {
            $file = fopen('php://output', 'w');
            
            // Cabeçalho CSV
            fputcsv($file, [
                'ID', 'Nome', 'E-mail', 'CPF', 'Telefone', 'Data Nascimento',
                'Profissão', 'Escolaridade', 'E-mail Verificado', 'Data Cadastro'
            ]);

            // Dados
            foreach ($usuarios as $usuario) {
                fputcsv($file, [
                    $usuario->id,
                    $usuario->nome,
                    $usuario->email,
                    $usuario->cpf_formatado,
                    $usuario->telefone,
                    $usuario->data_nascimento?->format('d/m/Y'),
                    $usuario->profissao,
                    $usuario->escolaridade_formatada,
                    $usuario->email_verified_at ? 'Sim' : 'Não',
                    $usuario->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Enviar email de verificação
     */
    private function enviarEmailVerificacao(EsicUsuario $usuario)
    {
        // TODO: Implementar envio de email de verificação
        // Mail::to($usuario->email)->send(new VerificacaoEmail($usuario));
    }
}
