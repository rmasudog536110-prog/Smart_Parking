<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ParkingLocation;

class ParkingLocationPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, ParkingLocation $location): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, ParkingLocation $location): bool
    {
        return false;
    }

    public function delete(User $user, ParkingLocation $location): bool
    {
        return false;
    }
}
