<?php

namespace App\Http\Controllers;

use App\Models\OuvidoriaManifestacao;
use App\Models\OuvidoriaMovimentacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OuvidoriaController extends Controller
{
    /**
     * Exibir página inicial da Ouvidoria
     */
    public function index()
    {
        try {
            $estatisticas = [
                'total_manifestacoes' => OuvidoriaManifestacao::count(),
                'manifestacoes_mes' => OuvidoriaManifestacao::whereMonth('created_at', now()->month)->count(),
                'tempo_medio_resposta' => 0,
                'taxa_atendimento' => 0,
                'por_categoria' => []
            ];

            // Tentar calcular estatísticas avançadas
            try {
                $estatisticas['tempo_medio_resposta'] = $this->calcularTempoMedioResposta();
            } catch (\Exception $e) {
                // Manter valor padrão 0
            }

            try {
                $estatisticas['taxa_atendimento'] = $this->calcularTaxaAtendimento();
            } catch (\Exception $e) {
                // Manter valor padrão 0
            }

            try {
                $estatisticas['por_categoria'] = $this->obterEstatisticasPorCategoria();
            } catch (\Exception $e) {
                // Manter array vazio
            }

            return view('ouvidoria.index', compact('estatisticas'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Exibir formulário de nova manifestação
     */
    public function create()
    {
        return view('ouvidoria.create');
    }

    /**
     * Armazenar nova manifestação
     */
    public function store(Request $request)
    {
        $rules = [
            'tipo' => 'required|in:reclamacao,sugestao,elogio,denuncia,informacao',
            'categoria' => 'required|in:saude,educacao,infraestrutura,transporte,meio_ambiente,seguranca,assistencia_social,administracao,outros',
            'assunto' => 'required|string|max:200',
            'descricao' => 'required|string|max:2000',
            'localizacao' => 'nullable|string|max:255',
            'nome' => 'required_unless:anonimo,1|string|max:255',
            'email' => 'required_unless:anonimo,1|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'anonimo' => 'nullable|boolean',
            'aceito_termos' => 'required|accepted',
            'uploaded_images' => 'nullable|array|max:5',
            'uploaded_images.*' => 'string'
        ];

        $validator = Validator::make($request->all(), $rules, [
            'tipo.required' => 'O tipo de manifestação é obrigatório.',
            'categoria.required' => 'A categoria é obrigatória.',
            'assunto.required' => 'O assunto é obrigatório.',
            'descricao.required' => 'A descrição é obrigatória.',
            'nome.required_unless' => 'O nome é obrigatório para manifestações não anônimas.',
            'email.required_unless' => 'O e-mail é obrigatório para manifestações não anônimas.',
            'email.email' => 'O e-mail deve ser válido.',
            'aceito_termos.accepted' => 'Você deve aceitar os termos de uso.',
            'uploaded_images.max' => 'Máximo de 5 imagens permitidas.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $isAnonimo = $request->boolean('anonimo');

            // Criar manifestação
            $manifestacao = OuvidoriaManifestacao::create([
                'tipo' => $request->tipo,
                'categoria' => $request->categoria,
                'assunto' => $request->assunto,
                'descricao' => $request->descricao,
                'localizacao' => $request->localizacao,
                'nome_manifestante' => $isAnonimo ? null : $request->nome,
                'email_manifestante' => $isAnonimo ? null : $request->email,
                'telefone_manifestante' => $isAnonimo ? null : $request->telefone,
                'anonima' => $isAnonimo,
                'status' => 'aberta',
                'data_manifestacao' => now(),
                'ip_manifestante' => $request->ip()
            ]);

            // Processar imagens enviadas
            if ($request->has('uploaded_images') && is_array($request->uploaded_images)) {
                $imagens = [];
                foreach ($request->uploaded_images as $imagemPath) {
                    if (Storage::disk('public')->exists($imagemPath)) {
                        $imagens[] = [
                            'caminho' => $imagemPath,
                            'nome_original' => basename($imagemPath),
                            'tipo' => 'imagem'
                        ];
                    }
                }
                if (!empty($imagens)) {
                    $manifestacao->update(['anexos' => $imagens]);
                }
            }

            // Registrar movimentação inicial
            OuvidoriaMovimentacao::create([
                'ouvidoria_manifestacao_id' => $manifestacao->id,
                'status' => OuvidoriaManifestacao::STATUS_ABERTA,
                'descricao' => 'Manifestação registrada no sistema',
                'usuario_id' => null,
                'data_movimentacao' => now()
            ]);

            // Enviar e-mail de confirmação (apenas para não anônimas)
            if (!$isAnonima) {
                $this->enviarEmailConfirmacao($manifestacao);
            }

            return redirect()->route('ouvidoria.consultar')
                ->with('success', 'Manifestação registrada com sucesso! Protocolo: ' . $manifestacao->protocolo)
                ->with('protocolo', $manifestacao->protocolo);

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao registrar manifestação. Tente novamente.')->withInput();
        }
    }

    /**
     * Consultar manifestação por protocolo
     */
    public function consultar(Request $request)
    {
        $manifestacao = null;

        if ($request->has('protocolo') && !empty($request->protocolo)) {
            $protocolo = preg_replace('/\D/', '', $request->protocolo);
            $manifestacao = OuvidoriaManifestacao::where('protocolo', $protocolo)->first();

            if (!$manifestacao) {
                return back()->with('error', 'Protocolo não encontrado.');
            }

            // Carregar movimentações
            $manifestacao->load(['movimentacoes' => function($query) {
                $query->orderBy('data_movimentacao', 'desc');
            }]);
        }

        return view('ouvidoria.consultar', compact('manifestacao'));
    }

    /**
     * Avaliar resposta da manifestação
     */
    public function avaliar(Request $request, $protocolo)
    {
        $validator = Validator::make($request->all(), [
            'avaliacao' => 'required|in:1,2,3,4,5',
            'comentario_avaliacao' => 'nullable|string|max:1000'
        ], [
            'avaliacao.required' => 'A avaliação é obrigatória.',
            'avaliacao.in' => 'A avaliação deve ser entre 1 e 5 estrelas.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $manifestacao = OuvidoriaManifestacao::where('protocolo', $protocolo)->firstOrFail();

            if ($manifestacao->status !== OuvidoriaManifestacao::STATUS_RESPONDIDA) {
                return back()->with('error', 'Apenas manifestações respondidas podem ser avaliadas.');
            }

            if ($manifestacao->avaliacao) {
                return back()->with('error', 'Esta manifestação já foi avaliada.');
            }

            $manifestacao->update([
                'avaliacao' => $request->avaliacao,
                'comentario_avaliacao' => $request->comentario_avaliacao,
                'data_avaliacao' => now()
            ]);

            // Registrar movimentação
            OuvidoriaMovimentacao::create([
                'ouvidoria_manifestacao_id' => $manifestacao->id,
                'status' => $manifestacao->status,
                'descricao' => 'Resposta avaliada com ' . $request->avaliacao . ' estrelas',
                'usuario_id' => null,
                'data_movimentacao' => now()
            ]);

            return back()->with('success', 'Avaliação registrada com sucesso! Obrigado pelo seu feedback.');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao registrar avaliação. Tente novamente.');
        }
    }

    /**
     * Exibir detalhes da manifestação (para administradores)
     */
    public function show($id)
    {
        $manifestacao = OuvidoriaManifestacao::with(['responsavel', 'movimentacoes.usuario'])
            ->findOrFail($id);

        return view('admin.ouvidoria.show', compact('manifestacao'));
    }

    /**
     * Atualizar status da manifestação (para administradores)
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:' . implode(',', array_keys(OuvidoriaManifestacao::getStatus())),
            'observacao' => 'nullable|string|max:1000',
            'resposta' => 'nullable|string|max:5000',
            'anexos_resposta.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,txt'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $manifestacao = OuvidoriaManifestacao::findOrFail($id);
            
            // Atualizar status
            $manifestacao->update([
                'status' => $request->status,
                'resposta' => $request->resposta,
                'respondida_em' => $request->status === OuvidoriaManifestacao::STATUS_RESPONDIDA ? now() : null,
                'responsavel_id' => auth()->id()
            ]);

            // Upload de anexos da resposta
            if ($request->hasFile('anexos_resposta')) {
                $anexosResposta = $manifestacao->anexos_resposta ?? [];
                
                foreach ($request->file('anexos_resposta') as $arquivo) {
                    $nomeArquivo = time() . '_' . Str::random(10) . '.' . $arquivo->getClientOriginalExtension();
                    $caminho = $arquivo->storeAs('ouvidoria/respostas/' . $manifestacao->protocolo, $nomeArquivo, 'public');
                    
                    $anexosResposta[] = [
                        'nome_original' => $arquivo->getClientOriginalName(),
                        'nome_arquivo' => $nomeArquivo,
                        'caminho' => $caminho,
                        'tamanho' => $arquivo->getSize(),
                        'tipo' => $arquivo->getMimeType(),
                        'data_upload' => now()->toDateTimeString()
                    ];
                }
                
                $manifestacao->update(['anexos_resposta' => $anexosResposta]);
            }

            // Registrar movimentação
            OuvidoriaMovimentacao::create([
                'ouvidoria_manifestacao_id' => $manifestacao->id,
                'status' => $request->status,
                'descricao' => $request->observacao ?: 'Status atualizado para: ' . $manifestacao->getStatusFormatado(),
                'usuario_id' => auth()->id(),
                'data_movimentacao' => now()
            ]);

            // Enviar e-mail de notificação (apenas para não anônimas)
            if ($request->status === OuvidoriaManifestacao::STATUS_RESPONDIDA && !$manifestacao->anonima) {
                $this->enviarEmailResposta($manifestacao);
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
        $manifestacao = OuvidoriaManifestacao::where('protocolo', $protocolo)->firstOrFail();
        
        $caminhoArquivo = 'ouvidoria/anexos/' . $protocolo . '/' . $arquivo;
        
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
        $manifestacao = OuvidoriaManifestacao::where('protocolo', $protocolo)->firstOrFail();
        
        $caminhoArquivo = 'ouvidoria/respostas/' . $protocolo . '/' . $arquivo;
        
        if (!Storage::disk('public')->exists($caminhoArquivo)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return Storage::disk('public')->download($caminhoArquivo);
    }

    /**
     * Obter estatísticas por categoria
     */
    private function obterEstatisticasPorCategoria()
    {
        return OuvidoriaManifestacao::selectRaw('categoria, COUNT(*) as total')
            ->groupBy('categoria')
            ->pluck('total', 'categoria')
            ->toArray();
    }

    /**
     * Calcular tempo médio de resposta
     */
    private function calcularTempoMedioResposta()
    {
        $manifestacoesRespondidas = OuvidoriaManifestacao::where('status', OuvidoriaManifestacao::STATUS_RESPONDIDA)
            ->whereNotNull('data_resposta')
            ->get();

        if ($manifestacoesRespondidas->isEmpty()) {
            return 0;
        }

        $totalDias = 0;
        foreach ($manifestacoesRespondidas as $manifestacao) {
            $totalDias += $manifestacao->data_manifestacao->diffInDays($manifestacao->data_resposta);
        }

        return round($totalDias / $manifestacoesRespondidas->count(), 1);
    }

    /**
     * Calcular taxa de atendimento
     */
    private function calcularTaxaAtendimento()
    {
        $total = OuvidoriaManifestacao::count();
        
        if ($total === 0) {
            return 0;
        }

        $atendidas = OuvidoriaManifestacao::whereIn('status', [
            OuvidoriaManifestacao::STATUS_RESPONDIDA,
            OuvidoriaManifestacao::STATUS_FINALIZADA
        ])->count();

        return round(($atendidas / $total) * 100, 1);
    }

    /**
     * Enviar e-mail de confirmação
     */
    private function enviarEmailConfirmacao($manifestacao)
    {
        try {
            // Implementar envio de e-mail
            // Mail::to($manifestacao->email_manifestante)->send(new OuvidoriaConfirmacao($manifestacao));
        } catch (\Exception $e) {
            // Log do erro
        }
    }

    /**
     * Enviar e-mail de resposta
     */
    private function enviarEmailResposta($manifestacao)
    {
        try {
            // Implementar envio de e-mail
            // Mail::to($manifestacao->email_manifestante)->send(new OuvidoriaResposta($manifestacao));
        } catch (\Exception $e) {
            // Log do erro
        }
    }
}