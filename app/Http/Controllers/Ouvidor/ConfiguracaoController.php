<?php

namespace App\Http\Controllers\Ouvidor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfiguracaoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'ouvidor']);
    }

    /**
     * Exibir as configurações do ouvidor
     */
    public function index()
    {
        $user = Auth::user();
        
        // Buscar configurações específicas do ouvidor
        $configuracoes = [
            'notificacoes_email' => $user->configuracoes['notificacoes_email'] ?? true,
            'notificacoes_sistema' => $user->configuracoes['notificacoes_sistema'] ?? true,
            'auto_atribuicao' => $user->configuracoes['auto_atribuicao'] ?? false,
            'prazo_padrao_resposta' => $user->configuracoes['prazo_padrao_resposta'] ?? 20,
            'assinatura_email' => $user->configuracoes['assinatura_email'] ?? '',
            'tema_dashboard' => $user->configuracoes['tema_dashboard'] ?? 'claro',
        ];
        
        return view('ouvidor.configuracoes.index', compact('configuracoes'));
    }

    /**
     * Atualizar as configurações do ouvidor
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'notificacoes_email' => ['boolean'],
            'notificacoes_sistema' => ['boolean'],
            'auto_atribuicao' => ['boolean'],
            'prazo_padrao_resposta' => ['required', 'integer', 'min:1', 'max:365'],
            'assinatura_email' => ['nullable', 'string', 'max:1000'],
            'tema_dashboard' => ['required', 'in:claro,escuro'],
        ]);

        // Atualizar configurações
        $configuracoes = $user->configuracoes ?? [];
        
        $configuracoes['notificacoes_email'] = $request->boolean('notificacoes_email');
        $configuracoes['notificacoes_sistema'] = $request->boolean('notificacoes_sistema');
        $configuracoes['auto_atribuicao'] = $request->boolean('auto_atribuicao');
        $configuracoes['prazo_padrao_resposta'] = $request->prazo_padrao_resposta;
        $configuracoes['assinatura_email'] = $request->assinatura_email;
        $configuracoes['tema_dashboard'] = $request->tema_dashboard;

        $user->update(['configuracoes' => $configuracoes]);

        return back()->with('success', 'Configurações atualizadas com sucesso!');
    }
}