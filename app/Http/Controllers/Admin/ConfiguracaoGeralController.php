<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfiguracaoGeral;
use App\Models\Media;
use App\Models\MediaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ConfiguracaoGeralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ConfiguracaoGeral::query();

        // Filtro de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('chave', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%")
                  ->orWhere('valor', 'like', "%{$search}%");
            });
        }

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('ativo', $request->status);
        }

        $configuracoes = $query->orderBy('chave')->paginate(15);
        
        return view('admin.configuracao-geral.index', compact('configuracoes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obter categorias do banco de dados
        $dbCategories = MediaCategory::active()->ordered()->get();
        
        // Converter para o formato esperado pela view (slug => nome)
        $categories = $dbCategories->pluck('name', 'slug')->toArray();
        
        // Se não houver categorias no banco, usar as categorias padrão
        if (empty($categories)) {
            $categories = \App\Models\Media::getCategories();
        }
        
        return view('admin.configuracao-geral.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chave' => 'required|string|max:255|unique:configuracao_gerais,chave',
            'valor' => 'nullable|string',
            'tipo' => 'required|in:texto,imagem,email,telefone,endereco',
            'descricao' => 'nullable|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'imagem_existing' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $valor = $request->valor;
        $uploadedFile = null;
        $imagemPath = null;

        // Se for tipo imagem e houver upload ou seleção existente
        if ($request->tipo === 'imagem') {
            if ($request->hasFile('imagem')) {
                $arquivo = $request->file('imagem');
                $uploadedFile = $arquivo;
                $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
                $caminho = $arquivo->storeAs('configuracoes', $nomeArquivo, 'public');
                $valor = $caminho;
                $imagemPath = $caminho;
            } elseif (!empty($request->imagem_existing)) {
                // Seleção da Biblioteca de Mídia
                $valor = $request->imagem_existing;
            }
        }

        $configuracao = ConfiguracaoGeral::create([
            'chave' => $request->chave,
            'valor' => $valor,
            'tipo' => $request->tipo,
            'descricao' => $request->descricao,
            'ativo' => $request->has('ativo')
        ]);

        // Registrar mídia na biblioteca se for um novo upload
        if (!empty($uploadedFile) && !empty($imagemPath)) {
            try {
                // Mapear categoria pela chave
                $categoria = 'outros';
                $chaveLower = strtolower($request->chave);
                if (str_contains($chaveLower, 'brasao')) {
                    $categoria = 'brasao';
                } elseif (str_contains($chaveLower, 'logo')) {
                    $categoria = 'logo';
                } elseif (str_contains($chaveLower, 'icone')) {
                    $categoria = 'icone';
                }

                Media::create([
                    'file_name' => basename($imagemPath),
                    'original_name' => $uploadedFile?->getClientOriginalName() ?? basename($imagemPath),
                    'mime_type' => $uploadedFile?->getMimeType() ?? 'image/jpeg',
                    'size' => $uploadedFile?->getSize() ?? (Storage::disk('public')->exists($imagemPath) ? Storage::disk('public')->size($imagemPath) : null),
                    'path' => $imagemPath,
                    'alt_text' => $request->descricao ?: $request->chave,
                    'title' => $request->descricao ?: ("Imagem da Configuração " . $request->chave),
                    'category' => $categoria,
                    'uploaded_by' => Auth::id(),
                    'model_type' => ConfiguracaoGeral::class,
                    'model_id' => $configuracao->id,
                    'collection_name' => 'configuracoes',
                    'disk' => 'public',
                    'name' => pathinfo($uploadedFile?->getClientOriginalName() ?? basename($imagemPath), PATHINFO_FILENAME),
                ]);
            } catch (\Throwable $e) {
                Log::warning('Falha ao registrar mídia de configuração (store): ' . $e->getMessage(), [
                    'configuracao_id' => $configuracao->id ?? null,
                    'path' => $imagemPath,
                ]);
            }
        }

        return redirect()->route('admin.configuracao-geral.index')
            ->with('success', 'Configuração criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ConfiguracaoGeral $configuracao)
    {
        return view('admin.configuracao-geral.show', compact('configuracao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConfiguracaoGeral $configuracao)
    {
        // Obter categorias do banco de dados
        $dbCategories = MediaCategory::active()->ordered()->get();
        
        // Converter para o formato esperado pela view (slug => nome)
        $categories = $dbCategories->pluck('name', 'slug')->toArray();
        
        // Se não houver categorias no banco, usar as categorias padrão
        if (empty($categories)) {
            $categories = \App\Models\Media::getCategories();
        }
        
        return view('admin.configuracao-geral.edit', compact('configuracao', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConfiguracaoGeral $configuracao)
    {
        $validator = Validator::make($request->all(), [
            'chave' => 'required|string|max:255|unique:configuracao_gerais,chave,' . $configuracao->id,
            'valor' => 'nullable|string',
            'tipo' => 'required|in:texto,imagem,email,telefone,endereco',
            'descricao' => 'nullable|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'imagem_existing' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $valor = $request->valor;
        $novoUploadedFile = null;
        $novoImagemPath = null;

        // Se for tipo imagem: novo upload ou seleção existente
        if ($request->tipo === 'imagem') {
            if ($request->hasFile('imagem')) {
                // Deletar imagem anterior se existir e for arquivo local
                if (!empty($configuracao->valor) && Storage::disk('public')->exists($configuracao->valor)) {
                    Storage::disk('public')->delete($configuracao->valor);
                }
                $novoUploadedFile = $request->file('imagem');
                $nomeArquivo = time() . '_' . $novoUploadedFile->getClientOriginalName();
                $novoImagemPath = $novoUploadedFile->storeAs('configuracoes', $nomeArquivo, 'public');
                $valor = $novoImagemPath;
            } elseif (!empty($request->imagem_existing)) {
                $novoImagemPath = $request->imagem_existing;
                // Se anterior era arquivo local diferente do novo, remover
                if (!empty($configuracao->valor) && $configuracao->valor !== $novoImagemPath && Storage::disk('public')->exists($configuracao->valor)) {
                    Storage::disk('public')->delete($configuracao->valor);
                }
                $valor = $novoImagemPath;
            } else {
                // Manter valor atual se não houve novo upload ou seleção
                $valor = $configuracao->valor;
            }
        }

        $configuracao->update([
            'chave' => $request->chave,
            'valor' => $valor,
            'tipo' => $request->tipo,
            'descricao' => $request->descricao,
            'ativo' => $request->has('ativo')
        ]);

        // Registrar nova mídia se houve novo upload (não registrar para seleção existente)
        if (!empty($novoUploadedFile) && !empty($novoImagemPath)) {
            try {
                // Mapear categoria pela chave
                $categoria = 'outros';
                $chaveLower = strtolower($request->chave);
                if (str_contains($chaveLower, 'brasao')) {
                    $categoria = 'brasao';
                } elseif (str_contains($chaveLower, 'logo')) {
                    $categoria = 'logo';
                } elseif (str_contains($chaveLower, 'icone')) {
                    $categoria = 'icone';
                }

                Media::create([
                    'file_name' => basename($novoImagemPath),
                    'original_name' => $novoUploadedFile?->getClientOriginalName() ?? basename($novoImagemPath),
                    'mime_type' => $novoUploadedFile?->getMimeType() ?? 'image/jpeg',
                    'size' => $novoUploadedFile?->getSize() ?? (Storage::disk('public')->exists($novoImagemPath) ? Storage::disk('public')->size($novoImagemPath) : null),
                    'path' => $novoImagemPath,
                    'alt_text' => $request->descricao ?: $request->chave,
                    'title' => $request->descricao ?: ("Imagem da Configuração " . $request->chave),
                    'category' => $categoria,
                    'uploaded_by' => Auth::id(),
                    'model_type' => ConfiguracaoGeral::class,
                    'model_id' => $configuracao->id,
                    'collection_name' => 'configuracoes',
                    'disk' => 'public',
                    'name' => pathinfo($novoUploadedFile?->getClientOriginalName() ?? basename($novoImagemPath), PATHINFO_FILENAME),
                ]);
            } catch (\Throwable $e) {
                Log::warning('Falha ao registrar mídia de configuração (update): ' . $e->getMessage(), [
                    'configuracao_id' => $configuracao->id ?? null,
                    'path' => $novoImagemPath,
                ]);
            }
        }

        return redirect()->route('admin.configuracao-geral.index')
            ->with('success', 'Configuração atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConfiguracaoGeral $configuracao)
    {
        // Deletar arquivo de imagem se existir
        if ($configuracao->tipo === 'imagem' && $configuracao->valor && Storage::disk('public')->exists($configuracao->valor)) {
            Storage::disk('public')->delete($configuracao->valor);
        }

        $configuracao->delete();

        return redirect()->route('admin.configuracao-geral.index')
            ->with('success', 'Configuração removida com sucesso!');
    }
}
