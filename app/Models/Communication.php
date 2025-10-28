<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'subject',
        'content',
        'status',
        'user_id',
    ];

    /**
     * Get the user that created the communication.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the email details for this communication.
     */
    public function emailDetails(): HasOne
    {
        return $this->hasOne(EmailCommunication::class);
    }


    /**
     * Get the recipients for this communication.
     */
    public function recipients(): HasMany
    {
        return $this->hasMany(CommunicationRecipient::class);
    }
}