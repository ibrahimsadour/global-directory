<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public static function getValue($key, $default = null)
    {
        return static::where('key', $key)->value('value') ?? $default;
    }
}

