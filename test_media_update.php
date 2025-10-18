<?php

require_once 'vendor/autoload.php';

// Carregar o ambiente Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Media;
use App\Models\MediaCategory;

echo "=== TESTE DE ATUALIZAÇÃO DE MÍDIA ===\n\n";

// Buscar a mídia ID 74
$media = Media::find(74);
if (!$media) {
    echo "Mídia ID 74 não encontrada!\n";
    exit;
}

echo "Mídia encontrada:\n";
echo "ID: {$media->id}\n";
echo "Título: {$media->title}\n";
echo "Category ID atual: {$media->category_id}\n";

// Buscar categorias disponíveis
$categories = MediaCategory::all();
echo "\nCategorias disponíveis:\n";
foreach ($categories as $category) {
    echo "ID: {$category->id} - Nome: {$category->name}\n";
}

// Tentar atualizar para categoria ID 4 (Fotos)
echo "\n=== TENTANDO ATUALIZAR CATEGORIA ===\n";
echo "Atualizando category_id de {$media->category_id} para 4...\n";

$result = $media->update(['category_id' => 4]);
echo "Resultado da atualização: " . ($result ? 'SUCESSO' : 'FALHA') . "\n";

// Verificar se foi salvo
$media->refresh();
echo "Category ID após atualização: {$media->category_id}\n";

// Verificar diretamente no banco
$directQuery = \DB::table('media')->where('id', 74)->first();
echo "Category ID direto do banco: {$directQuery->category_id}\n";

echo "\n=== TESTE CONCLUÍDO ===\n";