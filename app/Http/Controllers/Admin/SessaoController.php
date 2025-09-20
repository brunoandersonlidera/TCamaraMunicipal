<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sessao;
use App\Models\Vereador;
use App\Models\ProjetoLei;
use App\Models\TipoSessao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SessaoController extends Controller
{
    public function index(Request $request)
    {
        $query = Sessao::with(['presidenteSessao', 'secretarioSessao', 'vereadores', 'projetosLei', 'tipoSessao']);

        // Filtros
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('numero_sessao', 'like', "%{$busca}%")
                  ->orWhere('observacoes', 'like', "%{$busca}%")
                  ->orWhereJsonContains('pauta', $busca);
            });
        }

        if ($request->filled('tipo_sessao_id')) {
            $query->where('tipo_sessao_id', $request->tipo_sessao_id);
        }

        // Manter compatibilidade com filtro antigo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('data_sessao', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data_sessao', '<=', $request->data_fim);
        }

        if ($request->filled('legislatura')) {
            $query->where('legislatura', $request->legislatura);
        }

        // Ordenação
        $orderBy = $request->get('order_by', 'data_sessao');
        $orderDirection = $request->get('order_direction', 'desc');
        $query->orderBy($orderBy, $orderDirection);

        $sessoes = $query->paginate(15)->withQueryString();
        
        // Buscar tipos de sessão para os filtros
        $tiposSessao = TipoSessao::ativo()->orderBy('ordem')->get();

        return view('admin.sessoes.index', compact('sessoes', 'tiposSessao'));
    }

    public function create()
    {
        $vereadores = Vereador::ativos()->orderBy('nome')->get();
        $projetosLei = ProjetoLei::where('status', 'em_tramitacao')->orderBy('numero')->get();
        return view('admin.sessoes.create', compact('vereadores', 'projetosLei'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_sessao' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('sessoes')->where(function ($query) use ($request) {
                    return $query->where('legislatura', $request->legislatura ?? date('Y'));
                })
            ],
            'tipo' => 'required|in:ordinaria,extraordinaria,solene',
            'data_sessao' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i|after:hora_inicio',
            'pauta' => 'required|array|min:1',
            'pauta.*' => 'required|string|max:500',
            'legislatura' => 'required|integer|min:2000|max:' . (date('Y') + 10),
            'presidente_id' => 'nullable|exists:vereadores,id',
            'secretario_id' => 'nullable|exists:vereadores,id',
            'vereadores' => 'array',
            'vereadores.*' => 'exists:vereadores,id',
            'projetos_lei' => 'array',
            'projetos_lei.*' => 'exists:projetos_lei,id',
            'transmissao_online' => 'nullable|url',
            'observacoes' => 'nullable|string|max:2000',
        ]);

        $sessao = Sessao::create([
            'numero_sessao' => $request->numero_sessao,
            'tipo' => $request->tipo,
            'data_sessao' => $request->data_sessao,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $request->hora_fim,
            'pauta' => $request->pauta,
            'legislatura' => $request->legislatura ?? date('Y'),
            'status' => 'agendada',
            'presidente_id' => $request->presidente_id,
            'secretario_id' => $request->secretario_id,
            'transmissao_online' => $request->transmissao_online,
            'observacoes' => $request->observacoes,
        ]);

        // Sincronizar vereadores presentes
        if ($request->has('vereadores')) {
            $presencas = [];
            foreach ($request->vereadores as $vereadorId) {
                $presencas[$vereadorId] = ['presente' => true];
            }
            $sessao->vereadores()->sync($presencas);
        }

        // Sincronizar projetos de lei
        if ($request->has('projetos_lei')) {
            $sessao->projetosLei()->sync($request->projetos_lei);
        }

        return redirect()->route('admin.sessoes.index')
            ->with('success', 'Sessão criada com sucesso!');
    }

    public function show(Sessao $sessao)
    {
        $sessao->load(['vereadores', 'presidenteSessao', 'secretarioSessao', 'projetosLei']);
        return view('admin.sessoes.show', compact('sessao'));
    }

    public function edit(Sessao $sessao)
    {
        $vereadores = Vereador::ativos()->orderBy('nome')->get();
        $projetosLei = ProjetoLei::where('status', 'em_tramitacao')->orderBy('numero')->get();
        $sessao->load(['vereadores', 'projetosLei']);
        return view('admin.sessoes.edit', compact('sessao', 'vereadores', 'projetosLei'));
    }

    public function update(Request $request, Sessao $sessao)
    {
        $request->validate([
            'numero_sessao' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('sessoes')->ignore($sessao->id)->where(function ($query) use ($request) {
                    return $query->where('legislatura', $request->legislatura ?? $sessao->legislatura);
                })
            ],
            'tipo' => 'required|in:ordinaria,extraordinaria,solene',
            'data_sessao' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fim' => 'nullable|date_format:H:i|after:hora_inicio',
            'pauta' => 'required|array|min:1',
            'pauta.*' => 'required|string|max:500',
            'legislatura' => 'required|integer|min:2000|max:' . (date('Y') + 10),
            'presidente_id' => 'nullable|exists:vereadores,id',
            'secretario_id' => 'nullable|exists:vereadores,id',
            'status' => 'required|in:agendada,em_andamento,finalizada,cancelada',
            'vereadores' => 'array',
            'vereadores.*' => 'exists:vereadores,id',
            'projetos_lei' => 'array',
            'projetos_lei.*' => 'exists:projetos_lei,id',
            'transmissao_online' => 'nullable|url',
            'observacoes' => 'nullable|string|max:2000',
            'arquivo_ata' => 'nullable|file|mimes:pdf|max:10240',
            'arquivo_pauta' => 'nullable|file|mimes:pdf|max:10240',
            // Campos de vídeo gravado
            'video_url' => 'nullable|url',
            'plataforma_video' => 'nullable|in:youtube,vimeo,facebook',
            'thumbnail_url' => 'nullable|url',
            'duracao_video' => 'nullable|integer|min:1',
            'descricao_video' => 'nullable|string|max:1000',
            'video_disponivel' => 'nullable|boolean',
            'data_gravacao' => 'nullable|date',
        ]);

        // Upload de arquivos
        if ($request->hasFile('arquivo_ata')) {
            // Deletar arquivo anterior se existir
            if ($sessao->ata) {
                Storage::disk('public')->delete($sessao->ata);
            }
            $sessao->ata = $request->file('arquivo_ata')->store('sessoes/atas', 'public');
        }

        if ($request->hasFile('arquivo_pauta')) {
            // Deletar arquivo anterior se existir
            if ($sessao->arquivo_pauta) {
                Storage::disk('public')->delete($sessao->arquivo_pauta);
            }
            $sessao->arquivo_pauta = $request->file('arquivo_pauta')->store('sessoes/pautas', 'public');
        }

        $sessao->update([
            'numero_sessao' => $request->numero_sessao,
            'tipo' => $request->tipo,
            'data_sessao' => $request->data_sessao,
            'hora_inicio' => $request->hora_inicio,
            'hora_fim' => $request->hora_fim,
            'pauta' => $request->pauta,
            'legislatura' => $request->legislatura,
            'status' => $request->status,
            'presidente_id' => $request->presidente_id,
            'secretario_id' => $request->secretario_id,
            'transmissao_online' => $request->transmissao_online,
            'observacoes' => $request->observacoes,
            // Campos de vídeo gravado
            'video_url' => $request->video_url,
            'plataforma_video' => $request->plataforma_video,
            'thumbnail_url' => $request->thumbnail_url,
            'duracao_video' => $request->duracao_video,
            'descricao_video' => $request->descricao_video,
            'video_disponivel' => $request->boolean('video_disponivel'),
            'data_gravacao' => $request->data_gravacao,
        ]);

        // Sincronizar vereadores presentes
        if ($request->has('vereadores')) {
            $presencas = [];
            foreach ($request->vereadores as $vereadorId) {
                $presencas[$vereadorId] = ['presente' => true];
            }
            $sessao->vereadores()->sync($presencas);
        } else {
            $sessao->vereadores()->detach();
        }

        // Sincronizar projetos de lei
        if ($request->has('projetos_lei')) {
            $sessao->projetosLei()->sync($request->projetos_lei);
        } else {
            $sessao->projetosLei()->detach();
        }

        return redirect()->route('admin.sessoes.index')
            ->with('success', 'Sessão atualizada com sucesso!');
    }

    public function destroy(Sessao $sessao)
    {
        // Deletar arquivos associados
        if ($sessao->ata) {
            Storage::disk('public')->delete($sessao->ata);
        }
        if ($sessao->arquivo_pauta) {
            Storage::disk('public')->delete($sessao->arquivo_pauta);
        }

        // Remover relacionamentos
        $sessao->vereadores()->detach();
        $sessao->projetosLei()->detach();

        $sessao->delete();

        return redirect()->route('admin.sessoes.index')
            ->with('success', 'Sessão excluída com sucesso!');
    }

    public function toggleStatus(Sessao $sessao)
    {
        $novoStatus = match($sessao->status) {
            'agendada' => 'em_andamento',
            'em_andamento' => 'finalizada',
            'finalizada' => 'agendada',
            'cancelada' => 'agendada',
            default => 'agendada'
        };

        $sessao->update(['status' => $novoStatus]);

        return redirect()->back()
            ->with('success', "Status da sessão alterado para: {$novoStatus}");
    }

    public function downloadAta(Sessao $sessao)
    {
        if (!$sessao->ata || !Storage::disk('public')->exists($sessao->ata)) {
            return redirect()->back()
                ->with('error', 'Arquivo de ata não encontrado.');
        }

        return Storage::disk('public')->download($sessao->ata, "Ata_Sessao_{$sessao->numero_sessao}.pdf");
    }

    public function downloadPauta(Sessao $sessao)
    {
        if (!$sessao->arquivo_pauta || !Storage::disk('public')->exists($sessao->arquivo_pauta)) {
            return redirect()->back()
                ->with('error', 'Arquivo de pauta não encontrado.');
        }

        return Storage::disk('public')->download($sessao->arquivo_pauta, "Pauta_Sessao_{$sessao->numero_sessao}.pdf");
    }

    // Métodos adicionais para funcionalidades específicas
    public function registrarPresenca(Request $request, Sessao $sessao)
    {
        $request->validate([
            'vereador_id' => 'required|exists:vereadores,id',
            'presente' => 'required|boolean',
            'observacoes' => 'nullable|string|max:500'
        ]);

        $sessao->vereadores()->updateExistingPivot($request->vereador_id, [
            'presente' => $request->presente,
            'observacoes' => $request->observacoes
        ]);

        return response()->json(['success' => true]);
    }

    public function adicionarItemPauta(Request $request, Sessao $sessao)
    {
        $request->validate([
            'item' => 'required|string|max:500'
        ]);

        $pauta = $sessao->pauta ?? [];
        $pauta[] = $request->item;
        
        $sessao->update(['pauta' => $pauta]);

        return response()->json(['success' => true, 'pauta' => $pauta]);
    }

    public function removerItemPauta(Request $request, Sessao $sessao)
    {
        $request->validate([
            'index' => 'required|integer|min:0'
        ]);

        $pauta = $sessao->pauta ?? [];
        
        if (isset($pauta[$request->index])) {
            unset($pauta[$request->index]);
            $pauta = array_values($pauta); // Reindexar array
            
            $sessao->update(['pauta' => $pauta]);
        }

        return response()->json(['success' => true, 'pauta' => $pauta]);
    }

    public function iniciarSessao(Sessao $sessao)
    {
        if ($sessao->status !== 'agendada') {
            return redirect()->back()
                ->with('error', 'Apenas sessões agendadas podem ser iniciadas.');
        }

        $sessao->update([
            'status' => 'em_andamento',
            'hora_inicio_real' => now()->format('H:i')
        ]);

        return redirect()->back()
            ->with('success', 'Sessão iniciada com sucesso!');
    }

    public function finalizarSessao(Sessao $sessao)
    {
        if ($sessao->status !== 'em_andamento') {
            return redirect()->back()
                ->with('error', 'Apenas sessões em andamento podem ser finalizadas.');
        }

        $sessao->update([
            'status' => 'finalizada',
            'hora_fim' => now()->format('H:i')
        ]);

        return redirect()->back()
            ->with('success', 'Sessão finalizada com sucesso!');
    }
}