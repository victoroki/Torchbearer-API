<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    public $table = 'resources';

    public $fillable = [
        'title',
        'category',
        'type',
        'size',
        'downloads',
        'rating',
        'description',
        'author',
        'date',
        'featured',
        'tags',
        'preview',
        'file_url'
    ];

    protected $casts = [
        'title' => 'string',
        'category' => 'string',
        'type' => 'string',
        'size' => 'string',
        'rating' => 'decimal:1',
        'description' => 'string',
        'author' => 'string',
        'date' => 'date',
        'featured' => 'boolean',
        'tags' => 'array',
        'preview' => 'boolean',
        'file_url' => 'string'
    ];

    public static array $rules = [
        'title' => 'required|string|max:255',
        'category' => 'required|string|max:50',
        'type' => 'required|string|max:50',
        'size' => 'nullable|string|max:20',
        'downloads' => 'nullable|integer',
        'rating' => 'nullable|numeric|min:1|max:5',
        'description' => 'nullable|string|max:65535',
        'author' => 'nullable|string|max:255',
        'date' => 'nullable|date',
        'featured' => 'nullable|boolean',
        'tags' => 'nullable|string',
        'preview' => 'nullable|boolean',
        'file_url' => 'nullable|string|max:255',
    ];
}