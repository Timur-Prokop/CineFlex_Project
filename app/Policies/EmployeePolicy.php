<?php

namespace App\Policies;

use App\Models\User;

class EmployeePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        return $user->isManager() || $user->isWorker();
    }

    public function view(User $user): bool
    {
        return $user->isManager();
    }

    public function create(User $user): bool
    {
        return $user->isManager();
    }

    public function store(User $user): bool
    {
        return $user->isManager();
    }

    public function edit(User $user): bool
    {
        return $user->isManager();
    }

    public function update(User $user, User $worker): bool
    {
        return $user->isManager();

    }

    public function destroy(User $user, User $worker): bool
    {
        return $user->isManager();
    }
}
