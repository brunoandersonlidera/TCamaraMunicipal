<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeroConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heroConfig = HeroConfiguration::getActive();
        return view('admin.hero-config.index', compact('heroConfig'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hero-configurations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string|max:350',
            'botao_primario_texto' => 'required|string|max:100',
            'botao_primario_link' => 'required|string|max:255',
            'botao_secundario_texto' => 'required|string|max:100',
            'botao_secundario_link' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $configuration = HeroConfiguration::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'botao_primario_texto' => $request->botao_primario_texto,
            'botao_primario_link' => $request->botao_primario_link,
            'botao_primario_nova_aba' => $request->has('botao_primario_nova_aba'),
            'botao_secundario_texto' => $request->botao_secundario_texto,
            'botao_secundario_link' => $request->botao_secundario_link,
            'botao_secundario_nova_aba' => $request->has('botao_secundario_nova_aba'),
            'mostrar_slider' => $request->has('mostrar_slider'),
            'ativo' => false // Nova configuração não fica ativa por padrão
        ]);

        return redirect()->route('admin.hero-configurations.index')
            ->with('success', 'Configuração do hero section criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(HeroConfiguration $heroConfiguration)
    {
        return view('admin.hero-configurations.show', compact('heroConfiguration'));
    }



    /**
     * Activate a specific configuration
     */
    public function activate(HeroConfiguration $heroConfiguration)
    {
        $heroConfiguration->activate();
        
        return redirect()->route('admin.hero-configurations.index')
            ->with('success', 'Configuração ativada com sucesso!');
    }

    /**
     * Show the form for editing the hero configuration.
     */
    public function edit()
    {
        $heroConfig = HeroConfiguration::getActive();
        return view('admin.hero-config.edit', compact('heroConfig'));
    }

    /**
     * Update the hero configuration.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Permitir título vazio para casos onde a imagem já contém o texto
            'titulo' => 'nullable|string|max:255',
            'descricao' => 'required|string|max:1000',
            'imagem_topo_id' => 'nullable|integer|exists:media,id',
            'imagem_descricao_id' => 'nullable|integer|exists:media,id',
            'intervalo' => 'required|integer|min:1000|max:30000',
            'transicao' => 'required|string|in:slide,fade,zoom',
            'autoplay' => 'boolean',
            'pausar_hover' => 'boolean',
            'mostrar_indicadores' => 'boolean',
            'mostrar_controles' => 'boolean',
            // Novas opções de imagem do topo
            'imagem_topo_altura_px' => 'nullable|integer|min:50|max:2000',
            'centralizar_imagem_topo' => 'nullable|boolean',
            // Nova opção: altura da imagem da descrição
            'imagem_descricao_altura_px' => 'nullable|integer|min:50|max:2000',
            // Novas opções: largura e centralização da imagem da descrição
            'imagem_descricao_largura_px' => 'nullable|integer|min:50|max:3000',
            'centralizar_imagem_descricao' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buscar ou criar configuração ativa
        $heroConfig = HeroConfiguration::getActive();
        
        if (!$heroConfig) {
            $heroConfig = new HeroConfiguration();
            $heroConfig->ativo = true;
        }

        // Atualizar dados
        // Evitar erro de NOT NULL no banco: usar string vazia quando não houver título
        $heroConfig->titulo = $request->titulo ?? '';
        $heroConfig->descricao = $request->descricao;
        $heroConfig->imagem_topo_id = $request->imagem_topo_id ?: null;
        $heroConfig->imagem_descricao_id = $request->imagem_descricao_id ?: null;
        $heroConfig->intervalo = $request->intervalo;
        $heroConfig->transicao = $request->transicao;
        $heroConfig->autoplay = $request->has('autoplay');
        $heroConfig->pausar_hover = $request->has('pausar_hover');
        $heroConfig->mostrar_indicadores = $request->has('mostrar_indicadores');
        $heroConfig->mostrar_controles = $request->has('mostrar_controles');
        // Aplicar novas opções de imagem do topo
        $heroConfig->imagem_topo_altura_px = $request->imagem_topo_altura_px ?: null;
        $heroConfig->centralizar_imagem_topo = $request->has('centralizar_imagem_topo');
        // Aplicar novas opções da imagem da descrição
        $heroConfig->imagem_descricao_altura_px = $request->imagem_descricao_altura_px ?: null;
        $heroConfig->imagem_descricao_largura_px = $request->imagem_descricao_largura_px ?: null;
        $heroConfig->centralizar_imagem_descricao = $request->has('centralizar_imagem_descricao');
        
        $heroConfig->save();

        return redirect()->route('admin.hero-config.index')
            ->with('success', 'Configurações do hero section atualizadas com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeroConfiguration $heroConfiguration)
    {
        if ($heroConfiguration->ativo) {
            return redirect()->route('admin.hero-configurations.index')
                ->with('error', 'Não é possível excluir a configuração ativa!');
        }

        $heroConfiguration->delete();

        return redirect()->route('admin.hero-configurations.index')
            ->with('success', 'Configuração do hero section excluída com sucesso!');
    }
}
