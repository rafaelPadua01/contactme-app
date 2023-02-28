<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileMessage extends Model
{
    use HasFactory;
    protected $fillable = ['file_directory', 'extension', 'size', 'sender_id', 'receiver_id', 'chat_id'];
}
