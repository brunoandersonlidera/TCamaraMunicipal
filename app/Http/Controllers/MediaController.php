<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\MediaCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    /**
     * Exibe a biblioteca de mídia
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Media::with('uploader')->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $medias = $query->paginate(20);

        // Se for uma requisição AJAX, retorna JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $medias->items(),
                'pagination' => [
                    'current_page' => $medias->currentPage(),
                    'last_page' => $medias->lastPage(),
                    'per_page' => $medias->perPage(),
                    'total' => $medias->total(),
                ]
            ]);
        }
        
        // Obter categorias do banco de dados
        $dbCategories = MediaCategory::active()->ordered()->get();
        
        // Converter para o formato esperado pela view (slug => nome)
        $categories = $dbCategories->pluck('name', 'slug')->toArray();
        
        // Se não houver categorias no banco, usar as categorias padrão
        if (empty($categories)) {
            $categories = Media::getCategories();
        }

        return view('admin.media.index', compact('medias', 'categories'));
    }

    /**
     * Exibe o formulário de upload
     */
    public function create(): View
    {
        // Obter categorias do banco de dados
        $dbCategories = MediaCategory::active()->ordered()->get();
        
        // Converter para o formato esperado pela view (slug => nome)
        $categories = $dbCategories->pluck('name', 'slug')->toArray();
        
        // Se não houver categorias no banco, usar as categorias padrão
        if (empty($categories)) {
            $categories = Media::getCategories();
        }
        
        return view('admin.media.create', compact('categories'));
    }

    /**
     * Processa o upload de arquivos
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
                // Limites: até 20 arquivos por envio, cada um com até 50MB
                'files' => 'required|array|min:1|max:20',
                'files.*' => 'required|file|max:51200', // 50MB máximo
                'category_id' => 'required|integer|exists:media_categories,id',
                'alt_text.*' => 'nullable|string|max:255',
                'title.*' => 'nullable|string|max:255',
                'description.*' => 'nullable|string|max:1000',
            ]);

        $uploadedFiles = [];
        $errors = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                try {
                    // Gera nome único para o arquivo
                    $filename = $this->generateUniqueFilename($file);
                    
                    // Define o caminho baseado na categoria
                    $path = "media/{$request->category}/" . $filename;
                    
                    // Faz o upload usando Storage
                    $storedPath = $file->storeAs("media/{$request->category}", $filename, 'public');
                    
                    // Cria o registro no banco usando campos do Spatie
                    $media = Media::create([
                        'model_type' => null, // Para arquivos independentes
                        'model_id' => null,
                        'uuid' => Str::uuid(),
                        'collection_name' => $request->category_id,
                        'name' => $request->input("title.{$index}") ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                        'file_name' => $filename,
                        'path' => $storedPath,
                        'mime_type' => $file->getMimeType(),
                        'disk' => 'public',
                        'conversions_disk' => 'public',
                        'size' => $file->getSize(),
                        'manipulations' => [],
                        'custom_properties' => [
                            'alt_text' => $request->input("alt_text.{$index}"),
                            'title' => $request->input("title.{$index}") ?: $file->getClientOriginalName(),
                            'description' => $request->input("description.{$index}"),
                        ],
                        'generated_conversions' => [],
                        'order_column' => null,
                        // Campos customizados adicionais
                        'original_name' => $file->getClientOriginalName(),
                        'path' => $storedPath,
                        'alt_text' => $request->input("alt_text.{$index}"),
                        'title' => $request->input("title.{$index}") ?: $file->getClientOriginalName(),
                        'description' => $request->input("description.{$index}"),
                        'category_id' => $request->category_id,
                        'uploaded_by' => Auth::id(),
                    ]);

                    $uploadedFiles[] = $media;
                    
                } catch (\Exception $e) {
                    $errors[] = "Erro ao fazer upload de {$file->getClientOriginalName()}: " . $e->getMessage();
                }
            }
        }

        if (empty($uploadedFiles) && !empty($errors)) {
            // Se não for AJAX, redireciona de volta com erro (evita exibir JSON em tela)
            if (!$request->ajax() && !$request->expectsJson()) {
                return redirect()->back()->with('error', 'Nenhum arquivo foi enviado com sucesso.');
            }
            return response()->json([
                'success' => false,
                'message' => 'Nenhum arquivo foi enviado com sucesso.',
                'errors' => $errors
            ], 422);
        }

        // Se não for AJAX, redireciona de volta à página anterior com mensagem de sucesso
        // Isso impede que o navegador mostre o JSON em submissões nativas do formulário
        if (!$request->ajax() && !$request->expectsJson()) {
            $successMessage = count($uploadedFiles) . ' arquivo(s) enviado(s) com sucesso!';
            if (!empty($errors)) {
                $successMessage .= ' Alguns arquivos não foram enviados: ' . implode('; ', $errors);
            }
            return redirect()->back()->with('status', $successMessage);
        }

        return response()->json([
            'success' => true,
            'message' => count($uploadedFiles) . ' arquivo(s) enviado(s) com sucesso!',
            'data' => $uploadedFiles,
            'errors' => $errors
        ]);
    }

    /**
     * Exibe detalhes de um arquivo
     */
    public function show(Media $media): JsonResponse
    {
        // Carregar relações necessárias para dados completos no modal
        $media->load(['uploader', 'mediaCategory']);
        
        // Garantir que os accessors (url, public_url, formatted_size, etc.) sejam incluídos no JSON
        $mediaArray = $media->toArray();
        
        // Incluir informações explícitas da categoria
        $mediaArray['category_id'] = $media->category_id;
        $mediaArray['category_slug'] = optional($media->mediaCategory)->slug ?? ($media->category ?? null);
        $mediaArray['category_name'] = optional($media->mediaCategory)->name ?? null;
        $mediaArray['category_icon'] = optional($media->mediaCategory)->icon ?? null;
        
        return response()->json([
            'success' => true,
            'data' => $mediaArray
        ]);
    }

    /**
     * Exibe o formulário de edição de mídia
     */
    public function edit($id): View
    {
        $media = Media::findOrFail($id);
        $categories = MediaCategory::active()->ordered()->get();
        
        return view('admin.media.edit', compact('media', 'categories'));
    }

    /**
     * Atualiza informações de um arquivo de mídia
     */
    public function update(Request $request, $id)
    {
        try {
            $media = Media::findOrFail($id);
            
            // Validar os dados
            $request->validate([
                'alt_text' => 'nullable|string|max:255',
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
                'category_id' => 'required|integer|exists:media_categories,id',
            ]);

            // Preparar dados validados
            $validatedData = [
                'alt_text' => $request->alt_text,
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
            ];

            // Atualizar os campos diretamente no modelo
            $updateResult = $media->update($validatedData);
            \Log::info('Resultado da atualização: ' . ($updateResult ? 'sucesso' : 'falha'));
            \Log::info('Category ID após atualização (sem fresh): ' . $media->category_id);
            
            $updatedMedia = $media->fresh();
            if ($updatedMedia) {
                \Log::info('Category ID após fresh: ' . $updatedMedia->category_id);
                \Log::info('Dados após atualização: ' . json_encode($updatedMedia->toArray()));
            } else {
                \Log::error('Fresh retornou null para media ID: ' . $media->id);
            }
            
            // Verificar se a requisição é AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Arquivo atualizado com sucesso!',
                    'data' => $updatedMedia
                ]);
            }

            // Para requisições normais (da página de edição), redirecionar com mensagem de sucesso
            return redirect()->route('admin.media.index')
                ->with('success', 'Mídia atualizada com sucesso!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dados inválidos.',
                    'errors' => $e->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar mídia: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao atualizar arquivo: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Erro ao atualizar mídia: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove um arquivo
     */
    public function destroy(Media $media): JsonResponse
    {
        try {
            $media->deleteFile();
            
            return response()->json([
                'success' => true,
                'message' => 'Arquivo removido com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover arquivo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Serve arquivos de mídia
     */
    public function serve(string $filename): Response
    {
        // Buscar apenas por 'file_name' (coluna existente). A remoção de 'filename' evita erro SQL 1054.
        $media = Media::where('file_name', $filename)->firstOrFail();

        $disk = $media->disk ?? 'public';
        $path = $media->path;
        $headers = [
            'Content-Type' => $media->mime_type ?? 'application/octet-stream',
            'Content-Disposition' => 'inline; filename="' . ($media->original_name ?? $media->file_name) . '"',
            'Cache-Control' => 'public, max-age=31536000', // Cache por 1 ano
        ];

        // Caso exista caminho relativo no Storage
        if (!empty($path) && Storage::disk($disk)->exists($path)) {
            $file = Storage::disk($disk)->get($path);
            return response($file, 200, $headers);
        }

        // Fallback para registros do Spatie que não possuem coluna 'path': usar caminho absoluto
        if (method_exists($media, 'getPath')) {
            try {
                $absolutePath = $media->getPath();
                if ($absolutePath && file_exists($absolutePath)) {
                    return response()->file($absolutePath, $headers);
                }
            } catch (\Throwable $e) {
                // prosseguir para 404
            }
        }

        abort(404, 'Arquivo não encontrado');
    }

    /**
     * Modal de seleção de mídia (para uso em outros formulários)
     */
    public function select(Request $request): View
    {
        $query = Media::with('mediaCategory')->orderBy('created_at', 'desc');

        // Filtros específicos para seleção
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        $media = $query->paginate(12);
        
        // Obter categorias do banco de dados
        $dbCategories = MediaCategory::active()->ordered()->get();
        
        // Converter para o formato esperado pela view (slug => nome)
        $categories = $dbCategories->pluck('name', 'slug')->toArray();
        
        // Se não houver categorias no banco, usar as categorias padrão
        if (empty($categories)) {
            $categories = Media::getCategories();
        }

        return view('admin.media.select', compact('media', 'categories'));
    }

    /**
     * API para buscar mídias (para uso em JavaScript)
     */
    public function api(Request $request): JsonResponse
    {
        $query = Media::with('mediaCategory')->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        // Paginação
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 20);
        $medias = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'media' => $medias->items(),
            'pagination' => [
                'current_page' => $medias->currentPage(),
                'last_page' => $medias->lastPage(),
                'per_page' => $medias->perPage(),
                'total' => $medias->total(),
                'from' => $medias->firstItem(),
                'to' => $medias->lastItem(),
            ]
        ]);
    }

    /**
     * Gera nome único para o arquivo
     */
    private function generateUniqueFilename($file): string
    {
        $extension = $file->getClientOriginalExtension();
        $basename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $basename = Str::slug($basename);
        
        do {
            $filename = $basename . '_' . Str::random(8) . '.' . $extension;
        } while (Media::where('file_name', $filename)->exists());
        
        return $filename;
    }
}