<?php

namespace App\Http\Controllers\Ouvidor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OuvidoriaManifestacao;
use Carbon\Carbon;

class NotificacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'ouvidor']);
    }

    /**
     * Listar todas as notificações do ouvidor
     */
    public function index()
    {
        $user = Auth::user();
        $notificacoes = $this->gerarNotificacoes($user);
        
        return view('ouvidor.notificacoes.index', compact('notificacoes'));
    }

    /**
     * Marcar uma notificação como lida
     */
    public function marcarLida($id)
    {
        // Implementar lógica para marcar notificação específica como lida
        // Por enquanto, apenas retorna sucesso
        
        return response()->json(['success' => true, 'message' => 'Notificação marcada como lida']);
    }

    /**
     * Marcar todas as notificações como lidas
     */
    public function marcarTodasLidas()
    {
        // Implementar lógica para marcar todas as notificações como lidas
        // Por enquanto, apenas retorna sucesso
        
        return response()->json(['success' => true, 'message' => 'Todas as notificações foram marcadas como lidas']);
    }

    /**
     * Gerar notificações baseadas no estado atual das manifestações
     */
    private function gerarNotificacoes($user)
    {
        $notificacoes = [];

        // Manifestações vencidas
        $vencidas = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
            ->whereIn('status', ['pendente', 'em_andamento'])
            ->where('prazo_resposta', '<', Carbon::now())
            ->get();

        foreach ($vencidas as $manifestacao) {
            $notificacoes[] = [
                'id' => 'vencida_' . $manifestacao->id,
                'tipo' => 'danger',
                'titulo' => 'Manifestação Vencida',
                'mensagem' => "A manifestação #{$manifestacao->protocolo} está com prazo vencido desde " . 
                             Carbon::parse($manifestacao->prazo_resposta)->diffForHumans(),
                'data' => $manifestacao->prazo_resposta,
                'lida' => false,
                'link' => route('admin.ouvidoria-manifestacoes.show', $manifestacao->id)
            ];
        }

        // Manifestações próximas ao vencimento (3 dias)
        $proximoVencimento = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
            ->whereIn('status', ['pendente', 'em_andamento'])
            ->where('prazo_resposta', '<=', Carbon::now()->addDays(3))
            ->where('prazo_resposta', '>', Carbon::now())
            ->get();

        foreach ($proximoVencimento as $manifestacao) {
            $diasRestantes = Carbon::now()->diffInDays(Carbon::parse($manifestacao->prazo_resposta));
            $notificacoes[] = [
                'id' => 'vencimento_' . $manifestacao->id,
                'tipo' => 'warning',
                'titulo' => 'Prazo Vencendo',
                'mensagem' => "A manifestação #{$manifestacao->protocolo} vence em {$diasRestantes} dia(s)",
                'data' => $manifestacao->prazo_resposta,
                'lida' => false,
                'link' => route('admin.ouvidoria-manifestacoes.show', $manifestacao->id)
            ];
        }

        // Novas manifestações atribuídas hoje
        $novasHoje = OuvidoriaManifestacao::where('ouvidor_responsavel_id', $user->id)
            ->where('status', 'pendente')
            ->whereDate('created_at', Carbon::today())
            ->get();

        foreach ($novasHoje as $manifestacao) {
            $notificacoes[] = [
                'id' => 'nova_' . $manifestacao->id,
                'tipo' => 'info',
                'titulo' => 'Nova Manifestação',
                'mensagem' => "Nova manifestação #{$manifestacao->protocolo} foi atribuída a você",
                'data' => $manifestacao->created_at,
                'lida' => false,
                'link' => route('admin.ouvidoria-manifestacoes.show', $manifestacao->id)
            ];
        }

        // Ordenar por data (mais recentes primeiro)
        usort($notificacoes, function($a, $b) {
            return Carbon::parse($b['data'])->timestamp - Carbon::parse($a['data'])->timestamp;
        });

        return $notificacoes;
    }
}