<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('name');
            $table->string('external_website_url')->nullable()->after('address');
            $table->json('reservation_settings')->nullable()->after('theme_settings');
            $table->boolean('show_public_profile')->default(false)->after('reservation_settings');
        });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['slug', 'external_website_url', 'reservation_settings', 'show_public_profile']);
        });
    }
};
