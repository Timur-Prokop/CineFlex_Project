<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    protected $table = 'genres';

    public $timestamps = false;

    protected $fillable = [
        'genre',
    ];

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(
            Film::class,
            'films_genres',
            'fk_genre',
            'fk_film'
        );
    }
}
