<?php

namespace App\Policies;

use App\Models\Shelter;
use App\Models\User;

class ShelterPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->hasAnyShelterRole($user);
    }

    public function view(User $user, Shelter $shelter): bool
    {
        return $this->hasAnyShelterRole($user);
    }

    public function create(User $user): bool
    {
        return $this->hasShelterRole($user, ['Shelter Board Admin']);
    }

    public function update(User $user, Shelter $shelter): bool
    {
        return $this->hasShelterRole($user, ['Shelter Board Admin']);
    }

    public function delete(User $user, Shelter $shelter): bool
    {
        return $this->hasShelterRole($user, ['Shelter Board Admin']);
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
