<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileImages extends Model
{
    use HasFactory;
    protected $fillable = ['image_name', 'image_size', 'image_extension', 'user_id', 'profile_id'];
}
