<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Governorate extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'latitude',
        'longitude',
        'is_active',
    ];
    protected $withCount = ['locations'];


    // كل محافظة لها اكثر من مدينة
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    //  كل محافظة لها اكثر من اعلان 
    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    // السيو
    public function seo()
    {
        return $this->morphOne(\App\Models\Seo::class, 'seoable');
    }

    // الحذف التلقائي لسجل السيو إذا تم حذف المحافظة 
    // يحذف ملفات الصورة تلقائيًا عند حذف السجل.
    protected static function booted()
    {
        static::deleting(function ($governorate) {
            if ($governorate->image) {
                Storage::disk('public')->delete($governorate->image);
            }

            // حذف بيانات السيو المرتبطة (اختياري)
            $governorate->seo()->delete();
        });
    }

}

