<?php

namespace App\Policies;

use App\Models\User;

class WorkersPolicy
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
        return $user->isManager();
    }

    public function update(User $user, User $worker): bool
    {
        return $user->isManager()
            || ($user->isWorker() && $user->id === $worker->id);
    }

    public function delete(User $user, User $worker): bool
    {
        return $user->isManager();
    }
}
