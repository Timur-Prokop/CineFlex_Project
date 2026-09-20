<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\AgeGroup;
use App\Models\Genre;
use App\Models\Warning;

class Film extends Model
{
    protected $table = 'films';

    protected $fillable = [
        'title',
        'duration',
        'pic_path',
        'page_pic_path',
        'description',
        'fk_id_age_group',
    ];

    public function ageGroup(): BelongsTo
    {
        return $this->belongsTo(
            AgeGroup::class,
            'fk_id_age_group'
        );
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(
            Genre::class,
            'films_genres',
            'fk_film',
            'fk_genre'
        );
    }

    public function warnings(): BelongsToMany
    {
        return $this->belongsToMany(
            Warning::class,
            'films_warnings',
            'fk_id_film',
            'fk_id_warning'
        );
    }

    public function screenings(): HasMany
    {
        return $this->hasMany(
            Screening::class,
            'fk_film'
        );
    }
}
