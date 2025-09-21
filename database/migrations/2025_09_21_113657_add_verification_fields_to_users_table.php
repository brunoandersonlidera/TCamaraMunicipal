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
        Schema::table('users', function (Blueprint $table) {
            $table->string('email_verification_token')->nullable()->after('email_verified_at');
            $table->timestamp('terms_accepted_at')->nullable()->after('email_verification_token');
            $table->timestamp('privacy_accepted_at')->nullable()->after('terms_accepted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email_verification_token', 'terms_accepted_at', 'privacy_accepted_at']);
        });
    }
};
