<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppContact extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_contacts';

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'notes',
        'group',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the messages for the contact.
     */
    public function messages()
    {
        return $this->hasMany(WhatsAppMessage::class, 'contact_id');
    }
}
