<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{

    protected $fillable = [
    'name',
    'slug',
    'image',
    'description',
    'is_active',
    'parent_id',
    ];

    protected $casts = [
    'is_active' => 'boolean',
    ];
    // الأنشطة التابعة لهذه الفئة
    public function businesses(): HasMany
    {
        return $this->hasMany(Business::class);
    }

    // الفئة الأم
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // الفئات الفرعية
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    // السيو
    public function seo()
    {
        return $this->morphOne(\App\Models\Seo::class, 'seoable');
    }
    //الحذف التلقائي لسجل السيو إذا تم حذف الفئة 
    // يحذف ملفات  تلقائيًا عند حذف السجل.
    protected static function booted()
    {
        static::deleting(function ($category) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            // حذف بيانات السيو المرتبطة (اختياري)
            $category->seo()->delete();
        });
    }


}
