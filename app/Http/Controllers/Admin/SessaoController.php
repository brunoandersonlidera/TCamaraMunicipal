<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sessao;
use App\Models\Vereador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SessaoController extends Controller
{
    public function index(Request $request)
    {
        $query = Sessao::with(['vereadores', 'user']);

        // Filtros
        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('numero', 'like', "%{$busca}%")
                  ->orWhere('titulo', 'like', "%{$busca}%")
                  ->orWhere('pauta', 'like', "%{$busca}%");
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('data_hora', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data_hora', '<=', $request->data_fim);
        }

        if ($request->filled('legislatura')) {
            $query->where('legislatura', $request->legislatura);
        }

        // Ordenação
        $orderBy = $request->get('order_by', 'data_hora');
        $orderDirection = $request->get('order_direction', 'desc');
        $query->orderBy($orderBy, $orderDirection);

        $sessoes = $query->paginate(15)->withQueryString();

        return view('admin.sessoes.index', compact('sessoes'));
    }

    public function create()
    {
        $vereadores = Vereador::where('ativo', true)->orderBy('nome')->get();
        return view('admin.sessoes.create', compact('vereadores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|integer|min:1',
            'tipo' => 'required|in:ordinaria,extraordinaria,solene,especial',
            'titulo' => 'required|string|max:255',
            'data_hora' => 'required|date',
            'local' => 'required|string|max:255',
            'pauta' => 'required|string',
            'ata' => 'nullable|string',
            'observacoes' => 'nullable|string',
            'legislatura' => 'required|integer|min:1',
            'sessao_legislativa' => 'required|integer|min:1',
            'status' => 'required|in:agendada,em_andamento,finalizada,cancelada',
            'vereadores_presentes' => 'nullable|array',
            'vereadores_presentes.*' => 'exists:vereadores,id',
            'arquivo_ata' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'arquivo_pauta' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'transmissao_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
        ], [
            'numero.required' => 'O número da sessão é obrigatório.',
            'numero.integer' => 'O número deve ser um valor inteiro.',
            'numero.min' => 'O número deve ser maior que zero.',
            'tipo.required' => 'O tipo da sessão é obrigatório.',
            'tipo.in' => 'Tipo de sessão inválido.',
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título não pode ter mais de 255 caracteres.',
            'data_hora.required' => 'A data e hora são obrigatórias.',
            'data_hora.date' => 'Data e hora inválidas.',
            'local.required' => 'O local é obrigatório.',
            'local.max' => 'O local não pode ter mais de 255 caracteres.',
            'pauta.required' => 'A pauta é obrigatória.',
            'legislatura.required' => 'A legislatura é obrigatória.',
            'legislatura.integer' => 'A legislatura deve ser um número inteiro.',
            'legislatura.min' => 'A legislatura deve ser maior que zero.',
            'sessao_legislativa.required' => 'A sessão legislativa é obrigatória.',
            'sessao_legislativa.integer' => 'A sessão legislativa deve ser um número inteiro.',
            'sessao_legislativa.min' => 'A sessão legislativa deve ser maior que zero.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
            'vereadores_presentes.array' => 'Lista de vereadores inválida.',
            'vereadores_presentes.*.exists' => 'Vereador selecionado não existe.',
            'arquivo_ata.file' => 'Arquivo de ata inválido.',
            'arquivo_ata.mimes' => 'O arquivo da ata deve ser PDF, DOC ou DOCX.',
            'arquivo_ata.max' => 'O arquivo da ata não pode ter mais de 10MB.',
            'arquivo_pauta.file' => 'Arquivo de pauta inválido.',
            'arquivo_pauta.mimes' => 'O arquivo da pauta deve ser PDF, DOC ou DOCX.',
            'arquivo_pauta.max' => 'O arquivo da pauta não pode ter mais de 10MB.',
            'transmissao_url.url' => 'URL de transmissão inválida.',
            'youtube_url.url' => 'URL do YouTube inválida.',
        ]);

        // Upload de arquivos
        if ($request->hasFile('arquivo_ata')) {
            $validated['arquivo_ata'] = $request->file('arquivo_ata')->store('sessoes/atas', 'public');
        }

        if ($request->hasFile('arquivo_pauta')) {
            $validated['arquivo_pauta'] = $request->file('arquivo_pauta')->store('sessoes/pautas', 'public');
        }

        $validated['user_id'] = auth()->id();

        $sessao = Sessao::create($validated);

        // Sincronizar vereadores presentes
        if ($request->filled('vereadores_presentes')) {
            $sessao->vereadores()->sync($request->vereadores_presentes);
        }

        return redirect()
            ->route('admin.sessoes.index')
            ->with('success', 'Sessão criada com sucesso!');
    }

    public function show(Sessao $sessao)
    {
        $sessao->load(['vereadores', 'user']);
        return view('admin.sessoes.show', compact('sessao'));
    }

    public function edit(Sessao $sessao)
    {
        $vereadores = Vereador::where('ativo', true)->orderBy('nome')->get();
        $sessao->load('vereadores');
        return view('admin.sessoes.edit', compact('sessao', 'vereadores'));
    }

    public function update(Request $request, Sessao $sessao)
    {
        $validated = $request->validate([
            'numero' => 'required|integer|min:1',
            'tipo' => 'required|in:ordinaria,extraordinaria,solene,especial',
            'titulo' => 'required|string|max:255',
            'data_hora' => 'required|date',
            'local' => 'required|string|max:255',
            'pauta' => 'required|string',
            'ata' => 'nullable|string',
            'observacoes' => 'nullable|string',
            'legislatura' => 'required|integer|min:1',
            'sessao_legislativa' => 'required|integer|min:1',
            'status' => 'required|in:agendada,em_andamento,finalizada,cancelada',
            'vereadores_presentes' => 'nullable|array',
            'vereadores_presentes.*' => 'exists:vereadores,id',
            'arquivo_ata' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'arquivo_pauta' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'transmissao_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
        ], [
            'numero.required' => 'O número da sessão é obrigatório.',
            'numero.integer' => 'O número deve ser um valor inteiro.',
            'numero.min' => 'O número deve ser maior que zero.',
            'tipo.required' => 'O tipo da sessão é obrigatório.',
            'tipo.in' => 'Tipo de sessão inválido.',
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título não pode ter mais de 255 caracteres.',
            'data_hora.required' => 'A data e hora são obrigatórias.',
            'data_hora.date' => 'Data e hora inválidas.',
            'local.required' => 'O local é obrigatório.',
            'local.max' => 'O local não pode ter mais de 255 caracteres.',
            'pauta.required' => 'A pauta é obrigatória.',
            'legislatura.required' => 'A legislatura é obrigatória.',
            'legislatura.integer' => 'A legislatura deve ser um número inteiro.',
            'legislatura.min' => 'A legislatura deve ser maior que zero.',
            'sessao_legislativa.required' => 'A sessão legislativa é obrigatória.',
            'sessao_legislativa.integer' => 'A sessão legislativa deve ser um número inteiro.',
            'sessao_legislativa.min' => 'A sessão legislativa deve ser maior que zero.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
            'vereadores_presentes.array' => 'Lista de vereadores inválida.',
            'vereadores_presentes.*.exists' => 'Vereador selecionado não existe.',
            'arquivo_ata.file' => 'Arquivo de ata inválido.',
            'arquivo_ata.mimes' => 'O arquivo da ata deve ser PDF, DOC ou DOCX.',
            'arquivo_ata.max' => 'O arquivo da ata não pode ter mais de 10MB.',
            'arquivo_pauta.file' => 'Arquivo de pauta inválido.',
            'arquivo_pauta.mimes' => 'O arquivo da pauta deve ser PDF, DOC ou DOCX.',
            'arquivo_pauta.max' => 'O arquivo da pauta não pode ter mais de 10MB.',
            'transmissao_url.url' => 'URL de transmissão inválida.',
            'youtube_url.url' => 'URL do YouTube inválida.',
        ]);

        // Upload de novos arquivos
        if ($request->hasFile('arquivo_ata')) {
            // Deletar arquivo anterior se existir
            if ($sessao->arquivo_ata) {
                Storage::disk('public')->delete($sessao->arquivo_ata);
            }
            $validated['arquivo_ata'] = $request->file('arquivo_ata')->store('sessoes/atas', 'public');
        }

        if ($request->hasFile('arquivo_pauta')) {
            // Deletar arquivo anterior se existir
            if ($sessao->arquivo_pauta) {
                Storage::disk('public')->delete($sessao->arquivo_pauta);
            }
            $validated['arquivo_pauta'] = $request->file('arquivo_pauta')->store('sessoes/pautas', 'public');
        }

        $sessao->update($validated);

        // Sincronizar vereadores presentes
        if ($request->filled('vereadores_presentes')) {
            $sessao->vereadores()->sync($request->vereadores_presentes);
        } else {
            $sessao->vereadores()->detach();
        }

        return redirect()
            ->route('admin.sessoes.index')
            ->with('success', 'Sessão atualizada com sucesso!');
    }

    public function destroy(Sessao $sessao)
    {
        // Deletar arquivos associados
        if ($sessao->arquivo_ata) {
            Storage::disk('public')->delete($sessao->arquivo_ata);
        }

        if ($sessao->arquivo_pauta) {
            Storage::disk('public')->delete($sessao->arquivo_pauta);
        }

        // Remover relacionamentos
        $sessao->vereadores()->detach();

        $sessao->delete();

        return redirect()
            ->route('admin.sessoes.index')
            ->with('success', 'Sessão excluída com sucesso!');
    }

    public function toggleStatus(Sessao $sessao)
    {
        $statusOrder = ['agendada', 'em_andamento', 'finalizada'];
        $currentIndex = array_search($sessao->status, $statusOrder);
        
        if ($currentIndex !== false && $currentIndex < count($statusOrder) - 1) {
            $newStatus = $statusOrder[$currentIndex + 1];
        } else {
            $newStatus = 'agendada'; // Volta para o início
        }

        $sessao->update(['status' => $newStatus]);

        $statusLabels = [
            'agendada' => 'Agendada',
            'em_andamento' => 'Em Andamento',
            'finalizada' => 'Finalizada',
            'cancelada' => 'Cancelada'
        ];

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'status_label' => $statusLabels[$newStatus],
            'message' => "Status alterado para: {$statusLabels[$newStatus]}"
        ]);
    }

    public function downloadAta(Sessao $sessao)
    {
        if (!$sessao->arquivo_ata || !Storage::disk('public')->exists($sessao->arquivo_ata)) {
            abort(404, 'Arquivo de ata não encontrado.');
        }

        return Storage::disk('public')->download(
            $sessao->arquivo_ata,
            "Ata_Sessao_{$sessao->numero}_{$sessao->data_hora->format('Y-m-d')}.pdf"
        );
    }

    public function downloadPauta(Sessao $sessao)
    {
        if (!$sessao->arquivo_pauta || !Storage::disk('public')->exists($sessao->arquivo_pauta)) {
            abort(404, 'Arquivo de pauta não encontrado.');
        }

        return Storage::disk('public')->download(
            $sessao->arquivo_pauta,
            "Pauta_Sessao_{$sessao->numero}_{$sessao->data_hora->format('Y-m-d')}.pdf"
        );
    }
}