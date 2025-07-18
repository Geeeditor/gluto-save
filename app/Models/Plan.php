<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    protected $fillable = [
        'name', // Unique name for the plan
        'description', // Description of the plan
        'amount', // Amount for the plan
    ];
}
