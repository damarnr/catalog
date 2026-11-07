<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'sizes',
        'colors',
        'images',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getThumbnailAttribute(): ?string
{
    return !empty($this->images) ? asset('storage/' . $this->images[0]) : null;
}
}