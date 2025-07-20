<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessSocialLink extends Model
{
    protected $fillable = [
        'business_id',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
        'tiktok',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
