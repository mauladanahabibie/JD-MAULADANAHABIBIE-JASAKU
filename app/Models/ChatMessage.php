<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_messages';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'type',
        'content',
        'is_read',
        'service_id'
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
