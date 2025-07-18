<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserKyc extends Model
{
    //

    protected $fillable = [
        'user_id',
        'selfie_photo',
        'document_type',
        'document_front',
        'document_back',
        'document_id',
        'kyc_status',
        'application_status',
    ];

    /**
     * Get the user that owns the UserKyc
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
