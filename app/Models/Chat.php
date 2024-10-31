<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'message_id',
        'sender_id',
        'recipient_id',
        'message',
        'status' // sent, delivered, seen
    ];

    public function sentMessages()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receivedchats()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
