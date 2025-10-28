<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailCommunication extends Model
{
    use HasFactory;

    protected $fillable = [
        'communication_id',
        'from_email',
        'from_name',
        'reply_to',
        'cc',
        'bcc',
        'attachment_path',
    ];

    /**
     * Get the communication that owns the email details.
     */
    public function communication(): BelongsTo
    {
        return $this->belongsTo(Communication::class);
    }
}