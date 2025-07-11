<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessView extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'ip',
        'viewed_at',
    ];

    public $timestamps = true;

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    // العلاقة مع النشاط (Business)
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // ✅ scope للزيارات حسب IP (يمكنك استخدامه للفحص قبل الحفظ)
    public function scopeFromIp($query, $ip)
    {
        return $query->where('ip', $ip);
    }

    // ✅ scope لزيارات اليوم
    public function scopeToday($query)
    {
        return $query->whereDate('viewed_at', today());
    }

    // ✅ scope لآخر عدد ساعات معينة (لمنع التكرار)
    public function scopeWithinHours($query, $hours)
    {
        return $query->where('viewed_at', '>=', now()->subHours($hours));
    }
}
