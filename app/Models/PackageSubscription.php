<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageSubscription extends Model
{
    //
    protected $fillable = [
        'user_id', 'tier', 'withdrawal', 'total_contribution',
        'defaulted_weeks', 'package_status', 'is_primary',
          'sub_id', 'sub_fee'
    ];

    /**
     * Get the user that owns the PackageSubscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
