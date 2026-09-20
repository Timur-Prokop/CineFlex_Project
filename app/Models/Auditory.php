<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auditory extends Model
{
    protected $table = 'auditories';

    public $timestamps = false;

    protected $fillable = [
        'number',
        'seats_quantity',
    ];

    public function screenings(): HasMany
    {
        return $this->hasMany(
            Screening::class,
            'fk_auditory'
        );
    }
}
