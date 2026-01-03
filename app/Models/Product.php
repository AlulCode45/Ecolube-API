<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'description',
        'category',
        'brand',
        'image',
        'images',
        'price',
        'discount_price',
        'stock',
        'unit',
        'specifications',
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'images' => 'array',
        'specifications' => 'array',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at', 'desc');
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    // Accessors
    public function getDiscountPercentageAttribute()
    {
        if ($this->discount_price && $this->price > 0) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }
}
