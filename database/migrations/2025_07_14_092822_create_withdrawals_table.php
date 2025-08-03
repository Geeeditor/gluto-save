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

            // Fields for account withdrawal
            $table->string('account_name')->nullable(); // Account name for the withdrawal (nullable for wallet withdrawals)
            $table->string('account_number')->nullable(); // Account number for the withdrawal (nullable for wallet withdrawals)
            $table->string('bank_name')->nullable(); // Bank name for the withdrawal (nullable for wallet withdrawals)
            $table->string('crypto_option')->nullable(); // Bank name for the withdrawal (nullable for wallet withdrawals)

            // Fields for wallet withdrawal
            $table->string('wallet_address')->nullable(); // Wallet address for cryptocurrency withdrawal (nullable for account withdrawals)
            $table->string('network')->nullable(); // Network for cryptocurrency (nullable for account withdrawals)

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
