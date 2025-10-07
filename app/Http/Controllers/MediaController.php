<?php

namespace App\Http\Controllers;

use App\Models\Media;
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

        return view('admin.media.index', compact('medias'));
    }

    /**
     * Exibe o formulário de upload
     */
    public function create(): View
    {
        $categories = Media::getCategories();
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
            'category' => 'required|string|in:' . implode(',', array_keys(Media::getCategories())),
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
                        'collection_name' => $request->category,
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
                        'category' => $request->category,
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
        $media->load('uploader');
        
        // Garantir que os accessors (url, public_url, formatted_size, etc.) sejam incluídos no JSON
        $mediaArray = $media->toArray();
        
        return response()->json([
            'success' => true,
            'data' => $mediaArray
        ]);
    }

    /**
     * Atualiza informações de um arquivo de mídia
     */
    public function update(Request $request, Media $media): JsonResponse
    {
        $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|in:' . implode(',', array_keys(Media::getCategories())),
        ]);

        // Atualizar apenas custom_properties (evita erro SQL 1364 em campos inexistentes)
        $customProperties = $media->custom_properties ?? [];
        
        if ($request->has('alt_text')) {
            $customProperties['alt_text'] = $request->alt_text;
        }
        if ($request->has('title')) {
            $customProperties['title'] = $request->title;
        }
        if ($request->has('description')) {
            $customProperties['description'] = $request->description;
        }
        
        // Atualizar collection_name se categoria mudou
        if ($request->has('category')) {
            $customProperties['category'] = $request->category;
            $media->collection_name = $request->category;
        }
        
        // Salvar apenas custom_properties e collection_name (campos que existem na tabela Spatie)
        $media->custom_properties = $customProperties;
        $media->save();

        return response()->json([
            'success' => true,
            'message' => 'Arquivo atualizado com sucesso!',
            'data' => $media
        ]);
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
        $query = Media::orderBy('created_at', 'desc');

        // Filtros específicos para seleção
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        $medias = $query->paginate(12);
        $categories = Media::getCategories();

        return view('admin.media.select', compact('medias', 'categories'));
    }

    /**
     * API para buscar mídias (para uso em JavaScript)
     */
    public function api(Request $request): JsonResponse
    {
        $query = Media::orderBy('created_at', 'desc');

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