<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageVoice extends Model
{
    use HasFactory;
    protected $fillable = ['sender_id', 'receiver_id', 'chat_id', 'audio_name', 'status'];
}
