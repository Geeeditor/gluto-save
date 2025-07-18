<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalAccount extends Model
{
    //
    protected $fillable = [
        'user_id', // Foreign key to the user
        'account_name', // Name of the withdrawal account
        'account_number', // Account number for the withdrawal
        'bank_name', // Bank name for the withdrawal
        'account_type', // Type of account (e.g., 'savings', 'current')
    ];

    /**
     * Get the user that owns the WithdrawalAccount
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
