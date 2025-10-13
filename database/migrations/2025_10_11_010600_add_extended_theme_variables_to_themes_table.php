<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->string('primary_dark')->nullable()->after('accent_color');
            $table->string('light')->nullable()->after('primary_dark');
            $table->string('border')->nullable()->after('light');
            $table->string('text_muted')->nullable()->after('border');

            $table->string('success_bg')->nullable()->after('text_muted');
            $table->string('success_text')->nullable()->after('success_bg');
            $table->string('info_bg')->nullable()->after('success_text');
            $table->string('info_text')->nullable()->after('info_bg');
            $table->string('warning_bg')->nullable()->after('info_text');
            $table->string('warning_text')->nullable()->after('warning_bg');
            $table->string('danger_bg')->nullable()->after('warning_text');
            $table->string('danger_text')->nullable()->after('danger_bg');
            $table->string('secondary_bg')->nullable()->after('danger_text');
            $table->string('secondary_text')->nullable()->after('secondary_bg');
        });
    }

    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn([
                'primary_dark', 'light', 'border', 'text_muted',
                'success_bg', 'success_text',
                'info_bg', 'info_text',
                'warning_bg', 'warning_text',
                'danger_bg', 'danger_text',
                'secondary_bg', 'secondary_text',
            ]);
        });
    }
};