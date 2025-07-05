<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'city_id', 'category_id', 'keyword',
        'imported_at', 'total_fetched', 'new_saved'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function city() {
        return $this->belongsTo(Location::class, 'city_id');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
