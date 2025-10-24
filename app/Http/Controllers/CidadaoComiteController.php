<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ComiteIniciativaPopular;
use App\Models\AssinaturaEletronica;
use App\Models\ConfiguracaoGeral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CidadaoComiteController extends Controller
{
    /**
     * Exibir formulário para criar comitê
     */
    public function create()
    {
        $user = Auth::user();
        
        // Verificar se o cidadão pode criar comitês
        if (!$user->pode_criar_comite) {
            return redirect()->route('cidadao.dashboard')
                ->with('error', 'Você precisa ter sua conta verificada para criar comitês.');
        }
        
        $minimo_assinaturas = ConfiguracaoGeral::calcularMinimoAssinaturas();
        
        return view('cidadao.comites.create', compact('minimo_assinaturas'));
    }
    
    /**
     * Armazenar novo comitê criado pelo cidadão
     */
    public function store(Request $request)
    {
        Log::info('CidadaoComiteController::store - Início', [
            'user_id' => Auth::guard('cidadao')->id(),
            'request_data' => $request->all()
        ]);

        try {
            // Verificar se o usuário está autenticado
            $user = Auth::guard('cidadao')->user();
            if (!$user) {
                Log::error('CidadaoComiteController::store - Usuário não autenticado');
                return redirect()->route('login')->with('error', 'Você precisa estar logado para criar um comitê.');
            }

            Log::info('CidadaoComiteController::store - Usuário autenticado', ['user_id' => $user->id]);

            // Validar os dados do formulário
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'required|string|max:1000',
                'objetivo' => 'required|string|max:1000',
                'email' => 'required|email|max:255',
                'telefone' => 'required|string|max:20',
                'data_fim_coleta' => 'required|date|after:today',
                'ementa' => 'required|string',
                'texto_projeto_html' => 'required|string',
                'aceite_termos' => 'required|accepted'
            ]);

            Log::info('CidadaoComiteController::store - Dados validados com sucesso');

            // Criar o comitê
            $comite = ComiteIniciativaPopular::create([
                'nome' => $validatedData['nome'],
                'cpf' => $user->cpf,
                'email' => $validatedData['email'],
                'telefone' => $validatedData['telefone'],
                'endereco' => $user->endereco ?? '',
                'numero_assinaturas' => 1, // Primeira assinatura do responsável
                'minimo_assinaturas' => ConfiguracaoGeral::calcularMinimoAssinaturas(),
                'data_inicio_coleta' => now(),
                'data_fim_coleta' => $validatedData['data_fim_coleta'],
                'status' => 'aguardando_validacao', // Status inicial: aguardando validação da administração
                'descricao' => $validatedData['descricao'],
                'objetivo' => $validatedData['objetivo'],
                'observacoes' => '', // Campo para observações administrativas
                'ementa' => $validatedData['ementa'],
                'texto_projeto_html' => $validatedData['texto_projeto_html'],
                'data_ultima_alteracao' => now()
            ]);

            Log::info('CidadaoComiteController::store - Comitê criado', ['comite_id' => $comite->id]);

            // Criar a primeira assinatura eletrônica (do responsável)
            AssinaturaEletronica::create([
                'comite_iniciativa_popular_id' => $comite->id,
                'nome_completo' => $user->name,
                'cpf' => $user->cpf,
                'email' => $user->email,
                'telefone' => $user->telefone ?? $validatedData['telefone'],
                'data_nascimento' => $user->data_nascimento ?? now()->subYears(18)->toDateString(),
                'titulo_eleitor' => $user->titulo_eleitor ?? '000000000000',
                'zona_eleitoral' => $user->zona_eleitoral ?? '0000',
                'secao_eleitoral' => $user->secao_eleitoral ?? '0000',
                'endereco' => $user->endereco ?? 'Não informado',
                'numero' => $user->numero ?? 'S/N',
                'complemento' => $user->complemento ?? null,
                'bairro' => $user->bairro ?? 'Não informado',
                'cidade' => $user->cidade ?? 'Não informado',
                'estado' => $user->estado ?? 'MT',
                'cep' => $user->cep ?? '00000000',
                'data_assinatura' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'hash_assinatura' => hash('sha256', $user->cpf . $comite->id . now()->timestamp),
                'status' => 'validada', // Primeira assinatura já validada
                'ativo' => true
            ]);

            Log::info('CidadaoComiteController::store - Assinatura eletrônica criada');

            return redirect()->route('cidadao.comites.show', $comite)
                ->with('success', 'Comitê de Iniciativa Popular criado com sucesso!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('CidadaoComiteController::store - Erro de validação', [
                'errors' => $e->errors(),
                'user_id' => Auth::guard('cidadao')->id()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('CidadaoComiteController::store - Erro geral', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::guard('cidadao')->id()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar o comitê. Tente novamente.');
        }
    }
    
    /**
     * Assinar um comitê existente
     */
    public function assinar(Request $request, ComiteIniciativaPopular $comite)
    {
        $user = Auth::user();
        
        // Verificar se o cidadão pode assinar
        if (!$user->pode_assinar) {
            return response()->json([
                'success' => false,
                'message' => 'Você precisa ter sua conta verificada para assinar comitês.'
            ], 403);
        }
        
        // Verificar se o comitê está ativo
        if ($comite->status !== 'ativo') {
            return response()->json([
                'success' => false,
                'message' => 'Este comitê não está mais ativo para coleta de assinaturas.'
            ], 400);
        }
        
        // Verificar se ainda está no prazo
        if ($comite->data_fim_coleta && $comite->data_fim_coleta < now()) {
            return response()->json([
                'success' => false,
                'message' => 'O prazo para coleta de assinaturas deste comitê já expirou.'
            ], 400);
        }
        
        // Verificar se já assinou
        if (AssinaturaEletronica::where('comite_iniciativa_popular_id', $comite->id)
                                ->where('cidadao_id', $user->id)
                                ->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Você já assinou este comitê.'
            ], 400);
        }
        
        try {
            DB::beginTransaction();
            
            // Criar a assinatura
            AssinaturaEletronica::create([
                'comite_iniciativa_popular_id' => $comite->id,
                'cidadao_id' => $user->id,
                'nome_completo' => $user->nome_completo,
                'cpf' => $user->cpf,
                'email' => $user->email,
                'data_assinatura' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'pendente', // Será validada pela administração
            ]);
            
            // Atualizar contador de assinaturas
            $comite->increment('numero_assinaturas');
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Assinatura registrada com sucesso! Sua assinatura será validada pela equipe da Câmara.',
                'novo_total' => $comite->fresh()->numero_assinaturas
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao registrar assinatura. Tente novamente.'
            ], 500);
        }
    }
    
    /**
     * Visualizar detalhes de um comitê
     */
    public function show(ComiteIniciativaPopular $comite)
    {
        $user = Auth::user();
        
        // Verificar se o cidadão já assinou
        $jaAssinou = $user ? $user->jaAssinou($comite->id) : false;
        
        // Calcular progresso
        $progresso = $comite->minimo_assinaturas > 0 
            ? min(100, ($comite->numero_assinaturas / $comite->minimo_assinaturas) * 100)
            : 0;
        
        return view('cidadao.comites.show', compact('comite', 'jaAssinou', 'progresso'));
    }

    /**
     * Mostrar formulário de edição do comitê (apenas para responsável)
     */
    public function edit(ComiteIniciativaPopular $comite)
    {
        $user = Auth::user();
        
        // Verificar se é o responsável pelo comitê
        if ($comite->cidadao_responsavel_id !== $user->id) {
            abort(403, 'Você não tem permissão para editar este comitê.');
        }
        
        // Verificar se o comitê pode ser editado
        if (!$comite->podeSerEditado()) {
            return redirect()
                ->route('cidadao.comites.show', $comite)
                ->with('error', 'Este comitê não pode ser editado no status atual.');
        }
        
        return view('cidadao.comites.edit', compact('comite'));
    }

    /**
     * Atualizar comitê (apenas para responsável)
     */
    public function update(Request $request, ComiteIniciativaPopular $comite)
    {
        $user = Auth::user();
        
        // Verificar se é o responsável pelo comitê
        if ($comite->cidadao_responsavel_id !== $user->id) {
            abort(403, 'Você não tem permissão para editar este comitê.');
        }
        
        // Verificar se o comitê pode ser editado
        if (!$comite->podeSerEditado()) {
            return redirect()
                ->route('cidadao.comites.show', $comite)
                ->with('error', 'Este comitê não pode ser editado no status atual.');
        }

        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',
            'objetivo' => 'required|string|max:1000',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'data_fim_coleta' => 'required|date|after:today',
            'ementa' => 'required|string|max:500',
            'texto_projeto_html' => 'required|string'
        ]);

        // Atualizar dados do comitê
        $comite->update([
            'nome' => $validatedData['nome'],
            'email' => $validatedData['email'],
            'telefone' => $validatedData['telefone'],
            'data_fim_coleta' => $validatedData['data_fim_coleta'],
            'observacoes' => 'Descrição: ' . $validatedData['descricao'] . "\nObjetivo: " . $validatedData['objetivo'],
            'ementa' => $validatedData['ementa'],
            'texto_projeto_html' => $validatedData['texto_projeto_html'],
            'data_ultima_alteracao' => now()
        ]);

        return redirect()
            ->route('cidadao.comites.show', $comite)
            ->with('success', 'Comitê atualizado com sucesso!');
    }

    /**
     * Resubmeter comitê para validação após alterações
     */
    public function resubmeter(ComiteIniciativaPopular $comite)
    {
        $user = Auth::user();
        
        // Verificar se é o responsável pelo comitê
        if ($comite->cidadao_responsavel_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Você não tem permissão para resubmeter este comitê.'
            ], 403);
        }
        
        // Verificar se o comitê está aguardando alterações
        if (!$comite->isAguardandoAlteracoes()) {
            return response()->json([
                'success' => false,
                'message' => 'Este comitê não está aguardando alterações.'
            ], 400);
        }

        $comite->resubmeter();

        return response()->json([
            'success' => true,
            'message' => 'Comitê resubmetido para validação com sucesso!',
            'status' => $comite->status
        ]);
    }
}