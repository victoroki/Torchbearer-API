<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseClass extends Model
{
    public $table = 'license_classes';

    public $fillable = [
        'id',
        'license_type',
        'class',
        'scope',
        'min_qualification',
        'technical_qualification',
        'experience_requirements',
        'starting_license',
        'highest_achievable'
    ];

    protected $casts = [
        'license_type' => 'string',
        'class' => 'string',
        'scope' => 'string',
        'min_qualification' => 'string',
        'technical_qualification' => 'string',
        'experience_requirements' => 'string',
        'starting_license' => 'string',
        'highest_achievable' => 'string'
    ];

    public static array $rules = [
        'license_type' => 'required|string',
        'class' => 'required|string|max:10',
        'scope' => 'required|string|max:65535',
        'min_qualification' => 'required|string|max:100',
        'technical_qualification' => 'nullable|string',
        'experience_requirements' => 'nullable|string|max:65535',
        'starting_license' => 'nullable|string|max:10',
        'highest_achievable' => 'nullable|string|max:10',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
