<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ParkingSlot;

class ParkingSlotPolicy
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

    public function view(User $user, ParkingSlot $slot): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, ParkingSlot $slot): bool
    {
        return false;
    }

    public function delete(User $user, ParkingSlot $slot): bool
    {
        return false;
    }
}
