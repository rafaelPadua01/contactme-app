<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentBook extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'initial_hour', 'close_hour', 'days_work'];
}
