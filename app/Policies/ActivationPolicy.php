<?php

namespace App\Policies;

use App\Models\Activation;
use App\Models\User;

class ActivationPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->hasAnyShelterRole($user);
    }

    public function view(User $user, Activation $activation): bool
    {
        return $this->hasAnyShelterRole($user);
    }

    public function create(User $user): bool
    {
        return $this->hasShelterRole($user, ['Shelter Board Admin']);
    }

    public function update(User $user, Activation $activation): bool
    {
        return $this->hasShelterRole($user, ['Shelter Board Admin']);
    }

    public function delete(User $user, Activation $activation): bool
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
