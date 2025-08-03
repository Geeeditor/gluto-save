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
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('Gluto HEP');
            $table->string('app_description');
            $table->string('app_logo');
            $table->string('app_favicon');
            $table->string('support_email');
            $table->string('app_email');
            $table->string('app_phone');
            $table->string('app_address');
            $table->decimal('rate', 10, 2)->default(0.00); // User's wallet balance

            $table->json('app_social_links')->nullable(); // Stores social media links as JSON
            $table->boolean('withdrawal_enabled')->default(false);
            $table->boolean('contribution_enabled')->default(false);
            $table->boolean('subscription_enabled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
