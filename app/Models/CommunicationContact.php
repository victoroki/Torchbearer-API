<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    /**
     * Get the communications where this contact is a recipient.
     */
    public function communications()
    {
        return $this->hasMany(CommunicationRecipient::class, 'recipient_id')
            ->where('recipient_type', 'contact');
    }
}