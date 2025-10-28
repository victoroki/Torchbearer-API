<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    public $table = 'form_submissions';

    public $fillable = [
        'id',
        'email',
        'phone',
        'subject',
        'message',
        'form_type',
        'status',
        'source_url',
        'user_agent',
        'ip_address'
    ];

    protected $casts = [
        'email' => 'string',
        'phone' => 'string',
        'subject' => 'string',
        'message' => 'string',
        'form_type' => 'string',
        'status' => 'string',
        'source_url' => 'string',
        'user_agent' => 'string',
        'ip_address' => 'string'
    ];

    public static array $rules = [
        'email' => 'required|string|max:255',
        'phone' => 'required|string|max:50',
        'subject' => 'nullable|string|max:500',
        'message' => 'nullable|string|max:65535',
        'form_type' => 'nullable|string|max:100',
        'status' => 'nullable|string',
        'source_url' => 'nullable|string|max:500',
        'user_agent' => 'nullable|string|max:65535',
        'ip_address' => 'nullable|string|max:45',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
