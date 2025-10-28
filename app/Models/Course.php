<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $table = 'courses';

    public $fillable = [
        'name',
        'description',
        'trainer',
        'status'
    ];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'trainer' => 'string',
        'status' => 'integer'  // Changed from 'interger' to 'integer'
    ];

    public static array $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:65535',  
        'trainer' => 'nullable|string|max:15',  
        'status' => 'required|integer',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
    ];
}