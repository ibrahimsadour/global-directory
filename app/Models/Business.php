<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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

        'created_at',
        'updated_at'
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



    
    public function getOpeningStatus(): array
    {
        $now = Carbon::now();

        $daysMap = [
            'saturday'   => 'السبت',
            'sunday'     => 'الأحد',
            'monday'     => 'الاثنين',
            'tuesday'    => 'الثلاثاء',
            'wednesday'  => 'الأربعاء',
            'thursday'   => 'الخميس',
            'friday'     => 'الجمعة',
        ];

        $carbonDay = strtolower($now->englishDayOfWeek); // مثال: monday
        $today = $daysMap[$carbonDay] ?? null;

        $currentTime = $now->format('H:i:s');

        // نحصل على وقت اليوم الحالي
        $hour = $this->hours->firstWhere('day', $today);

        if ($hour && $hour->open_time && $hour->close_time) {

            // ✅ مفتوح 24 ساعة
            if ($hour->open_time === '00:00:00' && $hour->close_time === '23:59:59') {
                return [
                    'status' => 'open',
                    'label' => 'مفتوح 24 ساعة',
                ];
            }

            // ✅ مفتوح الآن
            if ($currentTime >= $hour->open_time && $currentTime < $hour->close_time) {
                return [
                    'status' => 'open',
                    'label' => 'مفتوح الآن – حتى ' . Carbon::createFromTimeString($hour->close_time)->format('g:i A'),
                ];
            }

            // ❌ مغلق الآن
            return [
                'status' => 'closed',
                'label' => 'مغلق – يفتح اليوم الساعة ' . Carbon::createFromTimeString($hour->open_time)->format('g:i A'),
            ];
        }

        // ✅ لا يوجد وقت محفوظ لليوم الحالي = اعتبره مفتوح
        return [
            'status' => 'open',
            'label' => 'مفتوح الآن',
        ];
    }

}
