<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            // Campos específicos para o lacinho de campanha
            $table->string('ribbon_campaign_label')->nullable()->after('ribbon_variant');
            $table->string('ribbon_campaign_link_url')->nullable()->after('ribbon_campaign_label');
            $table->boolean('ribbon_campaign_link_external')->default(false)->after('ribbon_campaign_link_url');

            // Campos específicos para o lacinho de luto
            $table->string('ribbon_mourning_label')->nullable()->after('mourning_enabled');
            $table->string('ribbon_mourning_link_url')->nullable()->after('ribbon_mourning_label');
            $table->boolean('ribbon_mourning_link_external')->default(false)->after('ribbon_mourning_link_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn([
                'ribbon_campaign_label',
                'ribbon_campaign_link_url',
                'ribbon_campaign_link_external',
                'ribbon_mourning_label',
                'ribbon_mourning_link_url',
                'ribbon_mourning_link_external',
            ]);
        });
    }
};