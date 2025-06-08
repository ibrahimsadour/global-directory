<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessHour extends Model
{
    protected $table = 'business_opening_hours';
    
    protected $fillable = [
        'business_id',
        'day',
        'open_time',
        'close_time',
    ];


    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
