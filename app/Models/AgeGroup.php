<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgeGroup extends Model
{
    protected $table = 'age_groups';

    public $timestamps = false;

    protected $fillable = [
        'age',
        'pic_path',
    ];

    public function films(): HasMany
    {
        return $this->hasMany(
            Film::class,
            'fk_id_age_group'
        );
    }
}
