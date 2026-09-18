<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'title',
    'duration',
    'pic_path',
    'page_pic_path',
    'description',
    'fk_id_age_group'
])]
class Film extends Model
{
    protected $table = 'films';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'duration' => 'integer',
            'fk_id_age_group' => 'integer',
        ];
    }
}
