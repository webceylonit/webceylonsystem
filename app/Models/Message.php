<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'project_id',
        'message',
        'is_read',
        'reply_to_id' // ✅ Add this to make it mass-assignable
    ];

    public function sender()
    {
        return $this->belongsTo(Employee::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Employee::class, 'receiver_id');
    }

    public function group()
    {
        return $this->belongsTo(MessageGroup::class, 'group_id');
    }

    // ✅ Reply relationship (self-referencing)
    public function replyTo()
    {
        return $this->belongsTo(Message::class, 'reply_to_id');
    }
}
