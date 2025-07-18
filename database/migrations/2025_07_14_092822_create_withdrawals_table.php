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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2); // Amount to be withdrawn
            $table->string('account_name'); // Account name for the withdrawal
            $table->string('account_number'); // Account number for the withdrawal
            $table->string('bank_name'); // Bank name for the withdrawal
            $table->string('account_type')->default('savings'); // Type of account (e.g., 'savings', 'current')
            $table->string('withdrawal_status')->default('pending'); // Status of the withdrawal
            $table->string('transaction_reference')->unique(); // Reference for the withdrawal transaction
            $table->timestamps();
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
