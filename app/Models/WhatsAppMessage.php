<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppMessage extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_messages';

    protected $fillable = [
        'contact_id',
        'recipient_phone',
        'recipient_name',
        'message',
        'media_type',
        'media_url',
        'media_caption',
        'status',
        'error_message',
        'sent_at',
        'user_id',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    /**
     * Get the contact that owns the message.
     */
    public function contact()
    {
        return $this->belongsTo(WhatsAppContact::class, 'contact_id');
    }

    /**
     * Get the user that sent the message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
