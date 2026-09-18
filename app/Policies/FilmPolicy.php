<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Film;

class FilmPolicy
{
    public function create(User $user): bool
    {
        return $user->isWorker();
    }

    public function new(User $user): bool
    {
        return $user->isWorker();
    }

    public function update(User $user, Film $film): bool
    {
        return $user->isWorker();
    }

    public function delete(User $user, Film $film): bool
    {
        return $user->isWorker();
    }
}
