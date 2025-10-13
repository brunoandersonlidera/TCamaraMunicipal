<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->string('ribbon_label')->nullable()->after('ribbon_variant');
            $table->string('ribbon_link_url')->nullable()->after('ribbon_label');
            $table->boolean('ribbon_link_external')->default(false)->after('ribbon_link_url');
        });
    }

    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn(['ribbon_label', 'ribbon_link_url', 'ribbon_link_external']);
        });
    }
};