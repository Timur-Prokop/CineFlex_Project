<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Warning extends Model
{
    protected $table = 'warnings';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'pic_path',
    ];

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(
            Film::class,
            'films_warnings',
            'fk_id_warning',
            'fk_id_film'
        );
    }
}
