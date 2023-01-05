<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'lastname',
        'uf',
        'cidade', 
        'bairro',
        'endereco',
        't_residencial',
        't_celular',
        'sexo',
        'user_id'
    ];

    protected $casts = [
        'file' => 'array'
    ];
}
