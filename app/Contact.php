<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'cpf',
        'name',
        'age',
        'whatsapp',
        'image',     
    ];
}
