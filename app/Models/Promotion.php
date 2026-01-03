<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'promo_type',
        'discount_value',
        'discount_percentage',
        'start_date',
        'end_date',
        'terms',
        'is_active',
        'order',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getIsValidAttribute()
    {
        return $this->is_active
            && $this->start_date <= now()
            && $this->end_date >= now();
    }

    public function getDaysRemainingAttribute()
    {
        if ($this->end_date) {
            return now()->diffInDays($this->end_date, false);
        }
        return 0;
    }
}
