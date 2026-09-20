<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'first_name',
    'prefix',
    'surname',
    'date_of_birth',
    'email',
    'password',
    'fk_role',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'email_verified_at' => 'datetime',
        ];
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function isManager(): bool
    {
        return $this->fk_role === 1;
    }

    public function isWorker(): bool
    {
        return $this->fk_role === 2;
    }

    public function isClient(): bool
    {
        return $this->fk_role === 3;
    }
}
