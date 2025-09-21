<?php

namespace App\Http\Controllers;

use App\Models\EsicSolicitacao;
use App\Models\EsicMovimentacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EsicController extends Controller
{
    /**
     * Exibir página inicial do E-SIC
     */
    public function index()
    {
        $estatisticas = [
            'total_solicitacoes' => EsicSolicitacao::count(),
            'solicitacoes_mes' => EsicSolicitacao::whereMonth('created_at', now()->month)->count(),
            'tempo_medio_resposta' => $this->calcularTempoMedioResposta(),
            'taxa_atendimento' => $this->calcularTaxaAtendimento()
        ];

        return view('esic.index', compact('estatisticas'));
    }

    /**
     * Exibir formulário de nova solicitação
     */
    public function create()
    {
        return view('esic.create');
    }

    /**
     * Armazenar nova solicitação
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome_solicitante' => 'required|string|max:255',
            'email_solicitante' => 'required|email|max:255',
            'cpf_solicitante' => 'required|string|size:14',
            'telefone_solicitante' => 'nullable|string|max:20',
            'endereco_solicitante' => 'nullable|string|max:500',
            'assunto' => 'required|string|max:255',
            'descricao' => 'required|string|max:5000',
            'categoria' => 'required|in:' . implode(',', array_keys(EsicSolicitacao::getCategorias())),
            'forma_recebimento' => 'required|in:' . implode(',', array_keys(EsicSolicitacao::getFormasRecebimento())),
            'anexos.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,txt',
            'aceita_termos' => 'required|accepted'
        ], [
            'nome_solicitante.required' => 'O nome é obrigatório.',
            'email_solicitante.required' => 'O e-mail é obrigatório.',
            'email_solicitante.email' => 'O e-mail deve ser válido.',
            'cpf_solicitante.required' => 'O CPF é obrigatório.',
            'cpf_solicitante.size' => 'O CPF deve ter 11 dígitos.',
            'assunto.required' => 'O assunto é obrigatório.',
            'descricao.required' => 'A descrição é obrigatória.',
            'categoria.required' => 'A categoria é obrigatória.',
            'forma_recebimento.required' => 'A forma de recebimento é obrigatória.',
            'anexos.*.max' => 'Cada arquivo deve ter no máximo 10MB.',
            'anexos.*.mimes' => 'Tipos de arquivo permitidos: PDF, DOC, DOCX, JPG, JPEG, PNG, TXT.',
            'aceita_termos.accepted' => 'Você deve aceitar os termos de uso.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Criar solicitação
            $solicitacao = EsicSolicitacao::create([
                'nome_solicitante' => $request->nome_solicitante,
                'email_solicitante' => $request->email_solicitante,
                'cpf_solicitante' => preg_replace('/\D/', '', $request->cpf_solicitante),
                'telefone_solicitante' => $request->telefone_solicitante,
                'endereco_solicitante' => $request->endereco_solicitante,
                'assunto' => $request->assunto,
                'descricao' => $request->descricao,
                'categoria' => $request->categoria,
                'forma_recebimento' => $request->forma_recebimento,
                'status' => EsicSolicitacao::STATUS_ABERTA,
                'data_solicitacao' => now(),
                'ip_solicitante' => $request->ip()
            ]);

            // Upload de anexos
            if ($request->hasFile('anexos')) {
                $anexos = [];
                foreach ($request->file('anexos') as $arquivo) {
                    $nomeArquivo = time() . '_' . Str::random(10) . '.' . $arquivo->getClientOriginalExtension();
                    $caminho = $arquivo->storeAs('esic/anexos/' . $solicitacao->protocolo, $nomeArquivo, 'public');
                    
                    $anexos[] = [
                        'nome_original' => $arquivo->getClientOriginalName(),
                        'nome_arquivo' => $nomeArquivo,
                        'caminho' => $caminho,
                        'tamanho' => $arquivo->getSize(),
                        'tipo' => $arquivo->getMimeType()
                    ];
                }
                $solicitacao->update(['anexos' => $anexos]);
            }

            // Registrar movimentação inicial
            EsicMovimentacao::create([
                'esic_solicitacao_id' => $solicitacao->id,
                'status' => EsicSolicitacao::STATUS_ABERTA,
                'descricao' => 'Solicitação registrada no sistema',
                'usuario_id' => null,
                'data_movimentacao' => now()
            ]);

            // Enviar e-mail de confirmação
            $this->enviarEmailConfirmacao($solicitacao);

            return redirect()->route('esic.consultar')
                ->with('success', 'Solicitação registrada com sucesso! Protocolo: ' . $solicitacao->protocolo)
                ->with('protocolo', $solicitacao->protocolo);

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao registrar solicitação. Tente novamente.')->withInput();
        }
    }

    /**
     * Consultar solicitação por protocolo
     */
    public function consultar(Request $request)
    {
        $solicitacao = null;

        if ($request->has('protocolo') && !empty($request->protocolo)) {
            $protocolo = preg_replace('/\D/', '', $request->protocolo);
            $solicitacao = EsicSolicitacao::where('protocolo', $protocolo)->first();

            if (!$solicitacao) {
                return back()->with('error', 'Protocolo não encontrado.');
            }

            // Carregar movimentações
            $solicitacao->load(['movimentacoes' => function($query) {
                $query->orderBy('data_movimentacao', 'desc');
            }]);
        }

        return view('esic.consultar', compact('solicitacao'));
    }

    /**
     * Exibir detalhes da solicitação (para administradores)
     */
    public function show($id)
    {
        $solicitacao = EsicSolicitacao::with(['responsavel', 'movimentacoes.usuario'])
            ->findOrFail($id);

        return view('admin.esic.show', compact('solicitacao'));
    }

    /**
     * Atualizar status da solicitação (para administradores)
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:' . implode(',', array_keys(EsicSolicitacao::getStatus())),
            'observacao' => 'nullable|string|max:1000',
            'resposta' => 'nullable|string|max:5000',
            'anexos_resposta.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,txt'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $solicitacao = EsicSolicitacao::findOrFail($id);
            
            // Atualizar status
            $solicitacao->update([
                'status' => $request->status,
                'resposta' => $request->resposta,
                'data_resposta' => $request->status === EsicSolicitacao::STATUS_RESPONDIDA ? now() : null,
                'responsavel_id' => auth()->id()
            ]);

            // Upload de anexos da resposta
            if ($request->hasFile('anexos_resposta')) {
                $anexosResposta = $solicitacao->anexos_resposta ?? [];
                
                foreach ($request->file('anexos_resposta') as $arquivo) {
                    $nomeArquivo = time() . '_' . Str::random(10) . '.' . $arquivo->getClientOriginalExtension();
                    $caminho = $arquivo->storeAs('esic/respostas/' . $solicitacao->protocolo, $nomeArquivo, 'public');
                    
                    $anexosResposta[] = [
                        'nome_original' => $arquivo->getClientOriginalName(),
                        'nome_arquivo' => $nomeArquivo,
                        'caminho' => $caminho,
                        'tamanho' => $arquivo->getSize(),
                        'tipo' => $arquivo->getMimeType(),
                        'data_upload' => now()->toDateTimeString()
                    ];
                }
                
                $solicitacao->update(['anexos_resposta' => $anexosResposta]);
            }

            // Registrar movimentação
            EsicMovimentacao::create([
                'esic_solicitacao_id' => $solicitacao->id,
                'status' => $request->status,
                'descricao' => $request->observacao ?: 'Status atualizado para: ' . $solicitacao->getStatusFormatado(),
                'usuario_id' => auth()->id(),
                'data_movimentacao' => now()
            ]);

            // Enviar e-mail de notificação
            if ($request->status === EsicSolicitacao::STATUS_RESPONDIDA) {
                $this->enviarEmailResposta($solicitacao);
            }

            return back()->with('success', 'Status atualizado com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar status. Tente novamente.');
        }
    }

    /**
     * Download de anexo
     */
    public function downloadAnexo($protocolo, $arquivo)
    {
        $solicitacao = EsicSolicitacao::where('protocolo', $protocolo)->firstOrFail();
        
        $caminhoArquivo = 'esic/anexos/' . $protocolo . '/' . $arquivo;
        
        if (!Storage::disk('public')->exists($caminhoArquivo)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return Storage::disk('public')->download($caminhoArquivo);
    }

    /**
     * Download de anexo da resposta
     */
    public function downloadAnexoResposta($protocolo, $arquivo)
    {
        $solicitacao = EsicSolicitacao::where('protocolo', $protocolo)->firstOrFail();
        
        $caminhoArquivo = 'esic/respostas/' . $protocolo . '/' . $arquivo;
        
        if (!Storage::disk('public')->exists($caminhoArquivo)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return Storage::disk('public')->download($caminhoArquivo);
    }

    /**
     * Calcular tempo médio de resposta
     */
    private function calcularTempoMedioResposta()
    {
        $solicitacoesRespondidas = EsicSolicitacao::where('status', EsicSolicitacao::STATUS_RESPONDIDA)
            ->whereNotNull('data_resposta')
            ->get();

        if ($solicitacoesRespondidas->isEmpty()) {
            return 0;
        }

        $totalDias = 0;
        foreach ($solicitacoesRespondidas as $solicitacao) {
            $totalDias += $solicitacao->data_solicitacao->diffInDays($solicitacao->data_resposta);
        }

        return round($totalDias / $solicitacoesRespondidas->count(), 1);
    }

    /**
     * Calcular taxa de atendimento
     */
    private function calcularTaxaAtendimento()
    {
        $total = EsicSolicitacao::count();
        
        if ($total === 0) {
            return 0;
        }

        $atendidas = EsicSolicitacao::whereIn('status', [
            EsicSolicitacao::STATUS_RESPONDIDA,
            EsicSolicitacao::STATUS_FINALIZADA
        ])->count();

        return round(($atendidas / $total) * 100, 1);
    }

    /**
     * Enviar e-mail de confirmação
     */
    private function enviarEmailConfirmacao($solicitacao)
    {
        try {
            // Implementar envio de e-mail
            // Mail::to($solicitacao->email_solicitante)->send(new EsicConfirmacao($solicitacao));
        } catch (\Exception $e) {
            // Log do erro
        }
    }

    /**
     * Enviar e-mail de resposta
     */
    private function enviarEmailResposta($solicitacao)
    {
        try {
            // Implementar envio de e-mail
            // Mail::to($solicitacao->email_solicitante)->send(new EsicResposta($solicitacao));
        } catch (\Exception $e) {
            // Log do erro
        }
    }
}