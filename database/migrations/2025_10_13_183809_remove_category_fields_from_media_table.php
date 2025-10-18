<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table) {
            // Remover os campos category e collection_name
            $table->dropColumn(['category', 'collection_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            // Adicionar os campos de volta se necessário
            $table->string('category')->default('outros')->after('category_id');
            $table->string('collection_name')->default('default')->after('category');
        });
    }
};
