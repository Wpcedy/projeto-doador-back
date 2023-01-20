<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pessoa extends Model
{
    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'telefone',
        'dtnascimento',
        'endereco',
    ];
}
