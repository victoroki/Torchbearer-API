<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingProgram extends Model
{
    public $table = 'training_programs';

    public $fillable = [
        'title',
        'description',
        'program_type',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'price',
        'early_bird_price',
        'features',
        'registration_link',
        'speaker',
        'status',
        'recording_url',
        'slides_url',
        'trainer_id'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'program_type' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'string',
        'early_bird_price' => 'string',
        'features' => 'string',
        'registration_link' => 'string',
        'speaker' => 'string',
        'status' => 'string',
        'recording_url' => 'string',
        'slides_url' => 'string'
    ];

    public static array $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:65535',
        'program_type' => 'required|string',
        'start_date' => 'required',
        'end_date' => 'nullable',
        'start_time' => 'nullable',
        'end_time' => 'nullable',
        'price' => 'nullable|string|max:100',
        'early_bird_price' => 'nullable|string|max:100',
        'features' => 'nullable|string',
        'registration_link' => 'nullable|string|max:500',
        'speaker' => 'nullable|string|max:255',
        'status' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'recording_url' => 'nullable|string|max:500',
        'slides_url' => 'nullable|string|max:500',
        'trainer_id' => 'nullable'
    ];

    
}
