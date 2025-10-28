<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    public $table = 'gallery_items';
    
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    public $fillable = [
        'title',
        'category',
        'type',
        'file_url',
        'description',
        'featured',
        'rating',
        'views',
        'tags'
    ];

    protected $casts = [
        'title' => 'string',
        'category' => 'string',
        'type' => 'string',
        'file_url' => 'string',
        'description' => 'string',
        'featured' => 'boolean',
        'rating' => 'decimal:1',
        'views' => 'integer',  
        'tags' => 'array' 
    ];

    public static array $rules = [
        'title' => 'required|string|max:255',
        'category' => 'required|string|max:50',
        'type' => 'required|string|in:image,video',
        'file_url' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:65535',
        'featured' => 'nullable|boolean',  
        'rating' => 'nullable|numeric|min:0|max:5',
        'views' => 'nullable|integer|min:0',
        'tags' => 'nullable|string'
    ];
}