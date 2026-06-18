<?php

namespace App\Policies;

use App\Models\GuestStay;
use App\Models\User;

class GuestStayPolicy
{
    public function view(User $user, GuestStay $guestStay): bool
    {
        return $this->hasAnyShelterRole($user);
    }

    public function create(User $user): bool
    {
        return $this->hasShelterRole($user, [
            'Shelter Board Admin',
            'Shelter Manager',
            'Shelter Staff',
        ]);
    }

    public function checkOut(User $user, GuestStay $guestStay): bool
    {
        return $this->hasShelterRole($user, [
            'Shelter Board Admin',
            'Shelter Manager',
            'Shelter Staff',
        ]);
    }

    protected function hasAnyShelterRole(User $user): bool
    {
        return $this->hasShelterRole($user, [
            'Shelter Board Admin',
            'Shelter Manager',
            'Shelter Staff',
            'Shelter Viewer',
        ]);
    }

    protected function hasShelterRole(User $user, array $roles): bool
    {
        if (method_exists($user, 'hasAnyRole')) {
            return $user->hasAnyRole($roles);
        }

        if (method_exists($user, 'hasRole')) {
            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    return true;
                }
            }
        }

        return false;
    }
}
