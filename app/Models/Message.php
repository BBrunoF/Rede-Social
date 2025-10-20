<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = ['user_sent_id', 'chats_id', 'message', 'is_read'];

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chats_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_sent_id');
    }
}

