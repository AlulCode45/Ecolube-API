<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $table = 'contact_info';

    protected $fillable = [
        'phone',
        'email',
        'address',
        'whatsapp',
        'social_media',
        'business_hours',
    ];

    protected $casts = [
        'social_media' => 'array',
        'business_hours' => 'array',
    ];
}
