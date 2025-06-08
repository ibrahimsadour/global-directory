<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable = ['meta_title', 'meta_description', 'meta_keywords'];
    protected $table = 'seos_table';
    protected $guarded = [];

    public function seoable()
    {
        return $this->morphTo();
    }
}

