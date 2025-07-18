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
        Schema::create('package_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('tier');
            $table->string('sub_id')->unique();
            $table->decimal('sub_fee', 10, 2);
            $table->decimal('total_contribution', 10, 2)->default(0.00);
            // $table->string('email');
            $table->integer('defaulted_weeks')->default(0);//Shows how many weeks owed by this account
            $table->string('package_status')->default('pending_activation');
            $table->boolean('is_primary')->default(false); // Indicates if this is the primary package
            $table->timestamps();
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_subscriptions');
    }
};
