<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageUploadController extends Controller
{
    /**
     * Upload de imagem via AJAX
     */
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ], [
            'image.required' => 'Selecione uma imagem.',
            'image.image' => 'O arquivo deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg ou gif.',
            'image.max' => 'A imagem não pode ser maior que 5MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $image = $request->file('image');
            $filename = $this->generateUniqueFilename($image);
            
            // Criar diretório se não existir
            $uploadPath = 'uploads/images/' . date('Y/m');
            Storage::disk('public')->makeDirectory($uploadPath);
            
            // Redimensionar e otimizar a imagem
            $processedImage = $this->processImage($image);
            
            // Salvar a imagem
            $fullPath = $uploadPath . '/' . $filename;
            Storage::disk('public')->put($fullPath, $processedImage);
            
            // Gerar thumbnail
            $thumbnailPath = $this->generateThumbnail($image, $uploadPath, $filename);
            
            return response()->json([
                'success' => true,
                'message' => 'Imagem enviada com sucesso!',
                'data' => [
                    'filename' => $filename,
                    'path' => $fullPath,
                    'url' => Storage::disk('public')->url($fullPath),
                    'thumbnail_path' => $thumbnailPath,
                    'thumbnail_url' => Storage::disk('public')->url($thumbnailPath),
                    'size' => Storage::disk('public')->size($fullPath),
                    'mime_type' => $image->getMimeType(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao fazer upload da imagem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload múltiplo de imagens
     */
    public function uploadMultiple(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'required|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'images.required' => 'Selecione pelo menos uma imagem.',
            'images.array' => 'Formato de dados inválido.',
            'images.max' => 'Máximo de 10 imagens por vez.',
            'images.*.image' => 'Todos os arquivos devem ser imagens.',
            'images.*.mimes' => 'As imagens devem ser do tipo: jpeg, png, jpg ou gif.',
            'images.*.max' => 'Cada imagem não pode ser maior que 5MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $uploadedImages = [];
            $uploadPath = 'uploads/images/' . date('Y/m');
            Storage::disk('public')->makeDirectory($uploadPath);

            foreach ($request->file('images') as $image) {
                $filename = $this->generateUniqueFilename($image);
                $processedImage = $this->processImage($image);
                $fullPath = $uploadPath . '/' . $filename;
                
                Storage::disk('public')->put($fullPath, $processedImage);
                $thumbnailPath = $this->generateThumbnail($image, $uploadPath, $filename);

                $uploadedImages[] = [
                    'filename' => $filename,
                    'path' => $fullPath,
                    'url' => Storage::disk('public')->url($fullPath),
                    'thumbnail_path' => $thumbnailPath,
                    'thumbnail_url' => Storage::disk('public')->url($thumbnailPath),
                    'size' => Storage::disk('public')->size($fullPath),
                    'mime_type' => $image->getMimeType(),
                ];
            }

            return response()->json([
                'success' => true,
                'message' => count($uploadedImages) . ' imagens enviadas com sucesso!',
                'data' => $uploadedImages
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao fazer upload das imagens: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Deletar imagem
     */
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Caminho da imagem é obrigatório.'
            ], 422);
        }

        try {
            $path = $request->input('path');
            
            // Verificar se o arquivo existe
            if (!Storage::disk('public')->exists($path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Imagem não encontrada.'
                ], 404);
            }

            // Deletar imagem principal
            Storage::disk('public')->delete($path);
            
            // Deletar thumbnail se existir
            $thumbnailPath = str_replace('/images/', '/images/thumbnails/', $path);
            if (Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            return response()->json([
                'success' => true,
                'message' => 'Imagem deletada com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar imagem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Gerar nome único para o arquivo
     */
    private function generateUniqueFilename($file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Str::random(40) . '.' . $extension;
        
        // Garantir que o nome é único
        $uploadPath = 'uploads/images/' . date('Y/m');
        while (Storage::disk('public')->exists($uploadPath . '/' . $filename)) {
            $filename = Str::random(40) . '.' . $extension;
        }
        
        return $filename;
    }

    /**
     * Processar e otimizar imagem
     */
    private function processImage($file)
    {
        // Se a biblioteca Intervention Image estiver disponível
        if (class_exists('Intervention\Image\Facades\Image')) {
            $image = Image::make($file);
            
            // Redimensionar se muito grande (máximo 1920px de largura)
            if ($image->width() > 1920) {
                $image->resize(1920, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
            
            // Otimizar qualidade
            return $image->encode(null, 85)->getEncoded();
        }
        
        // Fallback: retornar arquivo original
        return file_get_contents($file->getRealPath());
    }

    /**
     * Gerar thumbnail da imagem
     */
    private function generateThumbnail($file, $uploadPath, $filename)
    {
        $thumbnailPath = $uploadPath . '/thumbnails';
        Storage::disk('public')->makeDirectory($thumbnailPath);
        
        $thumbnailFullPath = $thumbnailPath . '/' . $filename;
        
        if (class_exists('Intervention\Image\Facades\Image')) {
            $thumbnail = Image::make($file)
                ->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode(null, 80);
                
            Storage::disk('public')->put($thumbnailFullPath, $thumbnail->getEncoded());
        } else {
            // Fallback: copiar imagem original como thumbnail
            $processedImage = $this->processImage($file);
            Storage::disk('public')->put($thumbnailFullPath, $processedImage);
        }
        
        return $thumbnailFullPath;
    }
}
