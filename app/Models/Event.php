<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $table = 'events';

    public $fillable = [
        'id',
        'title',
        'category',
        'date',
        'time',
        'location',
        'participants',
        'max_participants',
        'price',
        'description',
        'status',
        'featured',
        'registration_url'
    ];

    protected $casts = [
        'title' => 'string',
        'category' => 'string',
        'date' => 'date',
        'time' => 'string',
        'location' => 'string',
        'price' => 'string',
        'description' => 'string',
        'status' => 'string',
        'featured' => 'boolean',
        'registration_url' => 'string'
    ];

    public static array $rules = [
        'title' => 'required|string|max:255',
        'category' => 'required|string',
        'date' => 'required',
        'time' => 'required|string|max:50',
        'location' => 'required|string|max:255',
        'participants' => 'nullable',
        'max_participants' => 'required',
        'price' => 'required|string|max:50',
        'description' => 'required|string|max:65535',
        'status' => 'nullable|string',
        'featured' => 'nullable|boolean',
        'registration_url' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
