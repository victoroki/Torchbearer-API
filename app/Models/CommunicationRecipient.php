<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunicationRecipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'communication_id',
        'recipient_type',
        'recipient_id',
        'email',
        'phone',
        'name',
        'status',
        'status_message',
    ];

    /**
     * Get the communication that owns the recipient.
     */
    public function communication(): BelongsTo
    {
        return $this->belongsTo(Communication::class);
    }

    /**
     * Get the recipient user if recipient_type is 'user'.
     */
    public function user()
    {
        if ($this->recipient_type === 'user') {
            return $this->belongsTo(User::class, 'recipient_id');
        }
        return null;
    }
}