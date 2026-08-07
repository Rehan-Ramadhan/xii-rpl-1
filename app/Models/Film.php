<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'durasi',
        'rating',
        'deskripsi',
        'tanggal_rilis',
        'poster',
        'id_genre',
        'sutradara',
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'id_genre');
    }
    public function aktors()
    {
        return $this->belongsToMany(Aktor::class, 'aktor_films', 'id_film', 'id_aktor');
    }
}
