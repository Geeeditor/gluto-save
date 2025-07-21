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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2); // Amount paid
            $table->string('payment_proof')->nullable();
            $table->integer('payment_id'); // Used in looking up the parent model depending on the transaction type
            $table->string('transaction_reference')->unique(); // Reference for the payment transaction
            $table->string('payment_method')->default('gluto_transfer'); // Default payment type
            $table->string('payment_status')->default('pending'); // Status of the payment (e.g. pending, failed, approved)
            $table->string('payment_type'); // Type of payment (e.g., 'registration', 'contribution', 'subscription' etc.)
            $table->string('receipt')->nullable();
            $table->timestamps();
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
