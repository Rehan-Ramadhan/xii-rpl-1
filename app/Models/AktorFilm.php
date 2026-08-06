<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktorFilm extends Model
{
    protected $fillable = [
        'id_aktor',
        'id_film',
    ];
}
