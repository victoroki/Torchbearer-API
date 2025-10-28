<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    public $table = 'trainers';

    public $fillable = [
        'id',
        'name',
        'role',
        'bio',
        'image_url',
        'linkedin_url',
        'courses',
        'experience',
        'is_active'
    ];

    protected $casts = [
        'name' => 'string',
        'role' => 'string',
        'bio' => 'string',
        'image_url' => 'string',
        'linkedin_url' => 'string',
        'courses' => 'string',
        'experience' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'required|string|max:255',
        'role' => 'required|string|max:255',
        'bio' => 'nullable|string|max:65535',
        'image_url' => 'nullable|string|max:500',
        'linkedin_url' => 'nullable|string|max:500',
        'courses' => 'nullable|string',
        'experience' => 'nullable|string|max:100',
        'is_active' => 'nullable|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
