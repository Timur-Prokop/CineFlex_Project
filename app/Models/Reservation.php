<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';

    public $timestamps = false;

    protected $fillable = [
        'fk_seat',
        'fk_screening',
        'fk_user',
    ];

    public function seat()
    {
        return $this->belongsTo(Seat::class, 'fk_seat');
    }

    public function screening()
    {
        return $this->belongsTo(Screening::class, 'fk_screening');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_user');
    }
}
