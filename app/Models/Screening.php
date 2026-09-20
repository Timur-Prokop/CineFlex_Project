<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Screening extends Model
{
    protected $table = 'screenings';

    public $timestamps = false;

    protected $fillable = [
        'fk_film',
        'fk_auditory',
        'date_time',
    ];

    protected function casts(): array
    {
        return [
            'date_time' => 'datetime',
        ];
    }

    public function film(): BelongsTo
    {
        return $this->belongsTo(
            Film::class,
            'fk_film'
        );
    }

    public function auditory(): BelongsTo
    {
        return $this->belongsTo(
            Auditory::class,
            'fk_auditory'
        );
    }
}
