<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    //
    protected $fillable = [
        'user_id',
        'amount', // Amount paid
        'payment_proof',
        'transaction_reference', // Reference for the payment transaction
        'payment_method', // Default payment type
        'payment_status', // Status of the payment
        'payment_type', // Type of payment (e.g., 'activation', 'contribution', etc.)
        'receipt',
    ];

    /**
     * Get the user that owns the payment.
     */
    /**
     * Get the user that owns the Payments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
