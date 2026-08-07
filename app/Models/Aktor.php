<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aktor extends Model
{
    protected $fillable = [
        'nama_aktor',
        'slug',
        'gender',
        'umur',
        'foto',
    ];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'aktor_films', 'id_aktor', 'id_film');
    }
}
