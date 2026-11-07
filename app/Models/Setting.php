<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'brand_name', 'tagline', 'logo', 'whatsapp',
        'instagram', 'email', 'address', 'about',
    ];

    public static function current(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            ['brand_name' => config('app.name')]
        );
    }
}