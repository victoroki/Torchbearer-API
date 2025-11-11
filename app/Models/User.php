<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    public $table = 'users';

    public $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'is_active'
    ];

    protected $casts = [
        'name' => 'string',
        'username' => 'string',
        'email' => 'string',
        'password' => 'string',
        'role' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'nullable|string|max:100',
        'username' => 'required|string|max:50|unique:users,username',
        'email' => 'required|email|max:100|unique:users,email',
        'password' => 'required|string|min:8|max:255',
        'role' => 'nullable|in:admin,user',
        'is_active' => 'nullable|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * Automatically hash password when setting it
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}