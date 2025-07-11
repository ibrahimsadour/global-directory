<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;

class Business extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'location_id',
        'governorate_id',
        'name',
        'slug',
        
        // العنوان
        'address',
        'latitude',
        'longitude',

        'phone',
        'email',
        'website',
        'whatsapp',
        'description',

        // بياانات Google maps
        'place_id',
        'rating',
        'reviews_count',


        // الحالة
        'is_featured',
        'is_approved',
        'is_active',

        // الصورة
        'image',
        'gallery',

        // روابط السوشيال
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
    ];



    protected $casts = [
    'gallery' => 'array', // حتى تتعامل معها كـ array في Laravel
    ];

    // صاحب النشاط
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    // الفئة
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
    // الموقع
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
    // المحافظة
    public function governorate()
    {
        return $this->belongsTo(\App\Models\Governorate::class);
    }
    
    // ##################################################
    // التقييمات
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
    // عدد التقييمات
    public function getLocalReviewsCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    // متوسط التقييم
    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating'), 1) ?? 0;
    }
    // ##################################################


    // أوقات العمل
    public function hours(): HasMany
    {
        return $this->hasMany(BusinessHour::class);
    }

    // بيانات SEO
    public function seo(): MorphOne
    {
        return $this->morphOne(\App\Models\Seo::class, 'seoable');
    }

    // المستخدمين الذين أضافوه للمفضلة
    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    // الحذف التلقائي للسيو والصورة عند حذف الـ Business
    protected static function booted()
    {
        static::deleting(function ($business) {
            // حذف الصورة من التخزين
            if ($business->image) {
                Storage::disk('public')->delete($business->image);
            }

            // حذف صور الـ gallery
            if (is_array($business->gallery)) {
                foreach ($business->gallery as $galleryImage) {
                    Storage::disk('public')->delete($galleryImage);
                }
            }

            // حذف السيو
            $business->seo()->delete();
        });
    }
    // علاقة لتسجيل مشاهدات النشاط
    public function views()
    {
        return $this->hasMany(BusinessView::class);
    }

}
