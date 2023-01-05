<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_name',
        'marked_day',
        'marked_hour',
        'marked_service',
        'note',
        'user_id',
        'client_id',
        'appointment_id'
    ];
}
