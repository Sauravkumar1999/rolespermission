<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'direct_message_id',
        'message_id',
        'sender_id',
        'message',
        'status' // sent, delivered, seen
    ];

    public function directMessage(): BelongsTo
    {
        return $this->belongsTo(DirectMessage::class, 'direct_message_id');
    }

    /**
     * Get the user who sent this chat message.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
