<?php

namespace App\Policies;

use App\Models\Guest;
use App\Models\User;

class GuestPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->hasAnyOperationalRole($user);
    }

    public function view(User $user, Guest $guest): bool
    {
        return $this->hasAnyOperationalRole($user);
    }

    public function create(User $user): bool
    {
        return $this->hasShelterRole($user, [
            'Shelter Board Admin',
            'Shelter Manager',
            'Shelter Staff',
        ]);
    }

    public function update(User $user, Guest $guest): bool
    {
        return $this->hasShelterRole($user, [
            'Shelter Board Admin',
            'Shelter Manager',
            'Shelter Staff',
        ]);
    }

    protected function hasAnyOperationalRole(User $user): bool
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
