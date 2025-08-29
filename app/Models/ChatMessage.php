<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_messages';

    protected $fillable = [
        'room_id',
        'sender_id',
        'message',
    ];

    protected $casts = [
        'content' => 'array',
    ];
}
