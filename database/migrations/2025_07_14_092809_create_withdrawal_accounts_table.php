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
        Schema::create('withdrawal_accounts', function (Blueprint $table) {
            $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    
    // Fields for bank details
    $table->string('account_name')->nullable(); // Name of the withdrawal account
    $table->string('account_number', 10)->nullable(); // Account number for the withdrawal
    $table->string('bank_name')->nullable(); // Bank name for the withdrawal
    $table->string('account_type')->nullable(); // Type of account (e.g., 'savings', 'current')

    // Fields for cryptocurrency wallet
    $table->string('wallet_address')->nullable(); // Wallet address for cryptocurrency
    $table->string('network')->nullable(); // Network (e.g., Ethereum, Bitcoin)
    $table->string('crypto_option')->nullable(); // Selected cryptocurrency option

    // Additional field to indicate if bank details are not provided
    $table->boolean('no_bank_details')->default(false); // Flag to indicate no bank details

    $table->timestamps();
    $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_accounts');
    }
};
