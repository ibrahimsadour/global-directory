<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessGoogleData extends Model
{
    protected $table = 'business_google_data';

    protected $fillable = [
        'business_id',
        'google_maps_url',
        'google_reviews_url',
        'google_rating',
        'google_reviews_count',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
