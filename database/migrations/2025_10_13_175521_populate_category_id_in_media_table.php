<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\MediaCategory;
use App\Models\Media;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Obter todas as categorias
        $categories = MediaCategory::all()->keyBy('slug');
        
        // Obter todas as mídias
        $medias = Media::all();
        
        foreach ($medias as $media) {
            $categorySlug = $media->category;
            
            // Verificar se existe uma categoria com este slug
            if (isset($categories[$categorySlug])) {
                $categoryId = $categories[$categorySlug]->id;
                
                // Atualizar o category_id
                DB::table('media')
                    ->where('id', $media->id)
                    ->update(['category_id' => $categoryId]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Definir todos os category_id como null
        DB::table('media')->update(['category_id' => null]);
    }
};
