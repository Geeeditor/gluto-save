<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    //
    protected $fillable = [
        'user_id', // Foreign key to the user
        'account_name', // Name of the account holder
        'account_number', // Account number for the withdrawal
        'bank_name', // Name of the bank
        'account_type', // Type of account (e.g., 'savings', 'current')
        'withdrawal_status', // Status of the withdrawal (e.g., 'pending', 'completed', 'failed')
        'transaction_reference', // Unique reference for the withdrawal transaction
        'amount', // Amount to withdraw
        'wallet_address',
        'network',
        'crypto_option'

    ];

    /**
     * Get the user that owns the Withdrawal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
