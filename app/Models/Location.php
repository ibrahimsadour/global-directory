<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Location extends Model
{
    protected $fillable = [
        'area',
        'slug',
        'image',
        'description',
        'latitude',
        'longitude',
        'polygon',
        'governorate_id',
        'is_active',
    ];
    public function governorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class);
    }

    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class);
    }
    // السيو
    public function seo()
    {
        return $this->morphOne(\App\Models\Seo::class, 'seoable');
    }

    // الحذف التلقائي لسجل السيو إذا تم حذف المدينة / المنطقة 
    // يحذف ملفات الصورة تلقائيًا عند حذف السجل.
    protected static function booted()
    {
        static::deleting(function ($location) {
            if ($location->image) {
                Storage::disk('public')->delete($location->image);
            }

            // حذف بيانات السيو المرتبطة (اختياري)
            $location->seo()->delete();
        });
    }

}

