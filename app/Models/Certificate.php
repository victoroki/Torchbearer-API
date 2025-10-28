<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    public $table = 'certificates';

    public $fillable = [
        'id',
        'certificate_id',
        'recipient_name',
        'recipient_email',
        'course_name',
        'course_description',
        'issue_date',
        'status',
        'email_sent_at'
    ];

    protected $casts = [
        'certificate_id' => 'string',
        'recipient_name' => 'string',
        'recipient_email' => 'string',
        'course_name' => 'string',
        'course_description' => 'string',
        'issue_date' => 'date',
        'status' => 'string',
        'email_sent_at' => 'datetime'
    ];

    public static array $rules = [
        'certificate_id' => 'required|string|max:50',
        'recipient_name' => 'required|string|max:255',
        'recipient_email' => 'required|string|max:255',
        'course_name' => 'required|string|max:65535',
        'course_description' => 'nullable|string|max:65535',
        'issue_date' => 'nullable',
        'status' => 'nullable|string|max:50',
        'email_sent_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
