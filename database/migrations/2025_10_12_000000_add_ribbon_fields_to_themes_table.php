<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->boolean('ribbon_enabled')->default(false)->after('is_scheduled');
            $table->string('ribbon_variant')->nullable()->after('ribbon_enabled'); // 'october_pink', 'september_yellow', 'november_blue', 'mourning_black'
            $table->string('ribbon_primary')->nullable()->after('ribbon_variant');
            $table->string('ribbon_base')->nullable()->after('ribbon_primary');
            $table->string('ribbon_stroke')->nullable()->after('ribbon_base');
        });
    }

    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn(['ribbon_enabled', 'ribbon_variant', 'ribbon_primary', 'ribbon_base', 'ribbon_stroke']);
        });
    }
};