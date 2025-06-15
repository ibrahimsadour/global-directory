<?php

namespace App\Imports;

use App\Models\Business;
use App\Models\Seo;
use App\Models\User;
use App\Models\Category;
use App\Models\Location;
use App\Models\Governorate;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

// تعريف دوال التحقق بشكل آمن
if (!function_exists('isValidLatitude')) {
    function isValidLatitude($lat) {
        return is_numeric($lat) && $lat >= -90 && $lat <= 90;
    }
}

if (!function_exists('isValidLongitude')) {
    function isValidLongitude($lng) {
        return is_numeric($lng) && $lng >= -180 && $lng <= 180;
    }
}

class BusinessesImport implements ToModel, WithHeadingRow
{
    // تخزين الأخطاء
    public static array $errors = [];

    public function model(array $row)
    {
        // تحقق من العلاقات
        $relationsValid = true;

        if (!User::where('id', $row['user_id'])->exists()) {
            self::$errors[] = "خطأ في user_id ({$row['user_id']}) في السطر الخاص بالاسم: {$row['name']}";
            $relationsValid = false;
        }

        if (!Category::where('id', $row['category_id'])->exists()) {
            self::$errors[] = "خطأ في category_id ({$row['category_id']}) في السطر الخاص بالاسم: {$row['name']}";
            $relationsValid = false;
        }

        if (!Location::where('id', $row['location_id'])->exists()) {
            self::$errors[] = "خطأ في location_id ({$row['location_id']}) في السطر الخاص بالاسم: {$row['name']}";
            $relationsValid = false;
        }

        if (!Governorate::where('id', $row['governorate_id'])->exists()) {
            self::$errors[] = "خطأ في governorate_id ({$row['governorate_id']}) في السطر الخاص بالاسم: {$row['name']}";
            $relationsValid = false;
        }

        if (!$relationsValid) {
            return null;
        }

        // تحويل الإحداثيات لقيم رقمية
        $row['latitude'] = floatval($row['latitude']);
        $row['longitude'] = floatval($row['longitude']);

        // توليد العنوان تلقائيًا إذا لم يكن موجودًا
        $address = $row['address'];

        if (empty($address) && isValidLatitude($row['latitude']) && isValidLongitude($row['longitude'])) {
            $address = getAddressFromCoordinates($row['latitude'], $row['longitude']);
        }

        // توليد slug
        $slug = !empty($row['slug']) ? Str::slug($row['slug']) : Str::slug($row['name']);

        // إنشاء Business
        $business = Business::create([
            'user_id' => $row['user_id'],
            'category_id' => $row['category_id'],
            'location_id' => $row['location_id'],
            'governorate_id' => $row['governorate_id'],
            'name' => $row['name'],
            'slug' => $slug,
            'address' => $address,
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'website' => $row['website'],
            'whatsapp' => $row['whatsapp'],
            'description' => $row['description'],
            'is_featured' => $row['is_featured'],
            'is_approved' => $row['is_approved'],
            'is_active' => $row['is_active'],
            'image' => $row['image'],
            'facebook' => $row['facebook'],
            'instagram' => $row['instagram'],
            'twitter' => $row['twitter'],
            'linkedin' => $row['linkedin'],
            'youtube' => $row['youtube'],
        ]);

        // إنشاء السجل في جدول SEO
        $business->seo()->create([
            'meta_title' => $business->name,
            'meta_description' => $business->name,
            'meta_keywords' => $business->name,
        ]);

        return $business;
    }
}
