<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'logo',
        'website',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class, 'brand', 'name');
    }
}
