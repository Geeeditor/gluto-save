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
        Schema::create('user_kycs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('selfie_photo');
            $table->string('document_type');
            $table->string('document_front');
            $table->string('document_back');
            $table->string('document_id');
            $table->string('application_status')->default('pending_approval');
            $table->boolean('kyc_status')->default(false);
            $table->timestamps();
        });
    }

    /*
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('user_kycs');
    }
};
