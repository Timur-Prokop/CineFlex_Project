<?php

namespace App\Policies;

use App\Models\Screening;
use App\Models\User;

class ScreeningPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user): bool
    {
        return $user->isWorker();
    }

    public function new(User $user): bool
    {
        return $user->isWorker();
    }

    public function update(User $user, Screening $screening): bool
    {
        return $user->isWorker();
    }

    public function destroy(User $user, Screening $screening): bool
    {
        return $user->isWorker();
    }
}
