<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ComiteIniciativaPopular;
use App\Models\AssinaturaEletronica;
use App\Models\ConfiguracaoGeral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $user = Auth::user();
        
        // Verificar se o cidadão pode criar comitês
        if (!$user->podeCriarComite()) {
            return redirect()->route('cidadao.dashboard')
                ->with('error', 'Você precisa ter sua conta verificada para criar comitês.');
        }
        
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',
            'objetivo' => 'required|string|max:500',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'data_fim_coleta' => 'required|date|after:today',
            // Novos campos
            'ementa' => 'required|string',
            'texto_projeto_html' => 'required|string',
        ], [
            'nome.required' => 'O nome do comitê é obrigatório.',
            'descricao.required' => 'A descrição do comitê é obrigatória.',
            'objetivo.required' => 'O objetivo do comitê é obrigatório.',
            'email.required' => 'O email de contato é obrigatório.',
            'telefone.required' => 'O telefone de contato é obrigatório.',
            'data_fim_coleta.required' => 'A data fim da coleta é obrigatória.',
            'data_fim_coleta.after' => 'A data fim da coleta deve ser posterior a hoje.',
            'ementa.required' => 'A ementa do projeto de lei é obrigatória.',
            'texto_projeto_html.required' => 'O texto completo do projeto de lei é obrigatório.',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Criar o comitê
            $comite = ComiteIniciativaPopular::create([
                'nome' => $validated['nome'],
                'descricao' => $validated['descricao'],
                'objetivo' => $validated['objetivo'],
                'email' => $validated['email'],
                'telefone' => $validated['telefone'],
                'data_fim_coleta' => $validated['data_fim_coleta'],
                'cidadao_responsavel_id' => $user->id,
                'numero_assinaturas' => 1, // O criador já conta como primeira assinatura
                'minimo_assinaturas' => ConfiguracaoGeral::calcularMinimoAssinaturas(),
                'status' => 'ativo',
                'ementa' => $validated['ementa'],
                'texto_projeto_html' => $validated['texto_projeto_html'],
            ]);
            
            // Criar a primeira assinatura (do próprio criador)
            AssinaturaEletronica::create([
                'comite_iniciativa_popular_id' => $comite->id,
                'cidadao_id' => $user->id,
                'nome_completo' => $user->nome_completo,
                'cpf' => $user->cpf,
                'email' => $user->email,
                'data_assinatura' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'validada',
            ]);
            
            DB::commit();
            
            return redirect()->route('cidadao.dashboard')
                ->with('success', 'Comitê criado com sucesso! Você pode agora compartilhar para coletar assinaturas.');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar comitê. Tente novamente.');
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
}