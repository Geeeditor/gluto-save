<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivateDashboard extends Model
{
    //

    protected $fillable =  [
        'user_id',
        'wallet_balance',
        'dashboard_status',
   ];

    /**
     * Get the user that owns the ActivateDashboard
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class );
    }
}
