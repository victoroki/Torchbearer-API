<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsefulLink extends Model
{
    public $table = 'useful_links';

    public $fillable = [
        'id',
        'title',
        'url',
        'description',
        'category',
        'featured',
        'rating',
        'visits'
    ];

    protected $casts = [
        'title' => 'string',
        'url' => 'string',
        'description' => 'string',
        'category' => 'string',
        'featured' => 'boolean',
        'rating' => 'decimal:1'
    ];

    public static array $rules = [
        'title' => 'required|string|max:255',
        'url' => 'required|string|max:255',
        'description' => 'nullable|string|max:65535',
        'category' => 'required|string|max:50',
        'featured' => 'required|boolean',
        'rating' => 'required|numeric',
        'visits' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
