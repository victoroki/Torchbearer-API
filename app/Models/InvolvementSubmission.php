<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvolvementSubmission extends Model
{
    public $table = 'involvement_submissions';

    public $fillable = [
        'id',
        'name',
        'email',
        'organization',
        'phone',
        'message',
        'role_type',
        'status'
    ];

    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'organization' => 'string',
        'phone' => 'string',
        'message' => 'string',
        'role_type' => 'string',
        'status' => 'string'
    ];

    public static array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'organization' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:50',
        'message' => 'nullable|string|max:65535',
        'role_type' => 'required|string',
        'status' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    
}
