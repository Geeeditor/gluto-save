<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    //
    protected $fillable = [
        'app_name',
        'app_description',
        'app_logo',
        'app_favicon',
        'app_email',
        'app_phone',
        'support_email',
        'app_address',
        'app_social_links', // JSON field for social media links
        'contribution_enabled',
        'subscription_enabled',
        'withdrawal_enabled'
        // 'app_terms_conditions', // JSON field for terms and conditions
        // 'app_privacy_policy', // JSON field for privacy policy
    ];

}
