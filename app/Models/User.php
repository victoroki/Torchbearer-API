<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $table = 'users';

    public $fillable = [
        'id',
        'username',
        'email',
        'password',
        'role',
        'is_active'
    ];

    protected $casts = [
        'username' => 'string',
        'email' => 'string',
        'password' => 'string',
        'role' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'username' => 'nullable|string|max:50',
        'email' => 'required|string|max:100',
        'password' => 'required|string|max:255',
        'role' => 'nullable|string',
        'is_active' => 'nullable|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}