<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\MediaCategory;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Categorias padrão baseadas no método getCategories() do modelo Media
        $defaultCategories = [
            [
                'slug' => 'brasao',
                'name' => 'Brasões',
                'description' => 'Brasões e símbolos oficiais',
                'icon' => 'fa-shield-alt',
                'order' => 1,
            ],
            [
                'slug' => 'logo',
                'name' => 'Logos',
                'description' => 'Logotipos e marcas',
                'icon' => 'fa-trademark',
                'order' => 2,
            ],
            [
                'slug' => 'icone',
                'name' => 'Ícones',
                'description' => 'Ícones e símbolos',
                'icon' => 'fa-icons',
                'order' => 3,
            ],
            [
                'slug' => 'foto',
                'name' => 'Fotos',
                'description' => 'Fotografias e imagens',
                'icon' => 'fa-image',
                'order' => 4,
            ],
            [
                'slug' => 'documento',
                'name' => 'Documentos',
                'description' => 'Arquivos de documentos',
                'icon' => 'fa-file-alt',
                'order' => 5,
            ],
            [
                'slug' => 'banner',
                'name' => 'Banners',
                'description' => 'Banners e imagens de destaque',
                'icon' => 'fa-images',
                'order' => 6,
            ],
            [
                'slug' => 'galeria',
                'name' => 'Galeria',
                'description' => 'Imagens para galerias',
                'icon' => 'fa-photo-video',
                'order' => 7,
            ],
            [
                'slug' => 'noticias',
                'name' => 'Notícias',
                'description' => 'Imagens para notícias',
                'icon' => 'fa-newspaper',
                'order' => 8,
            ],
            [
                'slug' => 'outros',
                'name' => 'Outros',
                'description' => 'Outros tipos de mídia',
                'icon' => 'fa-folder',
                'order' => 9,
            ],
        ];

        // Inserir as categorias
        foreach ($defaultCategories as $category) {
            DB::table('media_categories')->insert(array_merge($category, [
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Limpar a tabela de categorias
        DB::table('media_categories')->truncate();
    }
};
