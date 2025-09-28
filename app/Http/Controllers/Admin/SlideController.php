<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = Slide::ordenados()->paginate(10);
        return view('admin.slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $opcoesTransicao = Slide::getOpcoesTransicao();
        $opcoesDirecao = Slide::getOpcoesDirecao();
        $proximaOrdem = Slide::getProximaOrdem();
        
        return view('admin.slides.create', compact('opcoesTransicao', 'opcoesDirecao', 'proximaOrdem'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'nullable|url',
            'nova_aba' => 'boolean',
            'ordem' => 'required|integer|min:0',
            'ativo' => 'boolean',
            'velocidade' => 'required|integer|min:1000|max:10000',
            'transicao' => 'required|in:fade,slide,zoom',
            'direcao' => 'required|in:left,right,up,down'
        ]);

        // Upload da imagem
        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem');
            $nomeArquivo = time() . '_' . Str::slug($validated['titulo']) . '.' . $imagem->getClientOriginalExtension();
            $caminhoImagem = '/images/slides/' . $nomeArquivo;
            
            // Criar diretório se não existir
            $diretorio = public_path('images/slides');
            if (!file_exists($diretorio)) {
                mkdir($diretorio, 0755, true);
            }
            
            // Mover arquivo para public/images/slides
            $imagem->move($diretorio, $nomeArquivo);
            $validated['imagem'] = $caminhoImagem;
        }

        // Definir valores padrão
        $validated['nova_aba'] = $request->has('nova_aba');
        $validated['ativo'] = $request->has('ativo');

        Slide::create($validated);

        return redirect()->route('admin.slides.index')
                        ->with('success', 'Slide criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slide $slide)
    {
        return view('admin.slides.show', compact('slide'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slide $slide)
    {
        $opcoesTransicao = Slide::getOpcoesTransicao();
        $opcoesDirecao = Slide::getOpcoesDirecao();
        
        return view('admin.slides.edit', compact('slide', 'opcoesTransicao', 'opcoesDirecao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slide $slide)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'nullable|url',
            'nova_aba' => 'boolean',
            'ordem' => 'required|integer|min:0',
            'ativo' => 'boolean',
            'velocidade' => 'required|integer|min:1000|max:10000',
            'transicao' => 'required|in:fade,slide,zoom',
            'direcao' => 'required|in:left,right,up,down'
        ]);

        // Upload da nova imagem se fornecida
        if ($request->hasFile('imagem')) {
            // Remover imagem antiga se existir
            if ($slide->imagem && str_starts_with($slide->imagem, '/images/')) {
                $caminhoAntigo = public_path($slide->imagem);
                if (file_exists($caminhoAntigo)) {
                    unlink($caminhoAntigo);
                }
            }

            $imagem = $request->file('imagem');
            $nomeArquivo = time() . '_' . Str::slug($validated['titulo']) . '.' . $imagem->getClientOriginalExtension();
            $caminhoImagem = '/images/slides/' . $nomeArquivo;
            
            // Criar diretório se não existir
            $diretorio = public_path('images/slides');
            if (!file_exists($diretorio)) {
                mkdir($diretorio, 0755, true);
            }
            
            // Mover arquivo para public/images/slides
            $imagem->move($diretorio, $nomeArquivo);
            $validated['imagem'] = $caminhoImagem;
        } else {
            // Manter imagem atual se não foi enviada nova
            unset($validated['imagem']);
        }

        // Definir valores padrão
        $validated['nova_aba'] = $request->has('nova_aba');
        $validated['ativo'] = $request->has('ativo');

        $slide->update($validated);

        return redirect()->route('admin.slides.index')
                        ->with('success', 'Slide atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slide $slide)
    {
        // Remover imagem do disco se existir
        if ($slide->imagem && str_starts_with($slide->imagem, '/images/')) {
            $caminhoImagem = public_path($slide->imagem);
            if (file_exists($caminhoImagem)) {
                unlink($caminhoImagem);
            }
        }

        $slide->delete();

        return redirect()->route('admin.slides.index')
                        ->with('success', 'Slide removido com sucesso!');
    }

    /**
     * Alternar status ativo/inativo
     */
    public function toggleStatus(Slide $slide)
    {
        $slide->update(['ativo' => !$slide->ativo]);
        
        $status = $slide->ativo ? 'ativado' : 'desativado';
        return response()->json([
            'success' => true,
            'message' => "Slide {$status} com sucesso!",
            'ativo' => $slide->ativo
        ]);
    }
}
