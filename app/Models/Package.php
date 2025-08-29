<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'currency',
        'duration_type',
        // 'duration_value',
        'perks',
        'goodies_count',
        'image',
        'icon',
        'is_featured',
        'status',
        // 'sort_order',
    ];

    protected $casts = [
        'perks' => 'array',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'status' => 'boolean',
        'goodies_count' => 'integer',
        'duration_value' => 'integer',
        'sort_order' => 'integer',
    ];
}
