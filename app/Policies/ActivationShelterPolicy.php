<?php

namespace App\Policies;

use App\Models\ActivationShelter;
use App\Models\User;

class ActivationShelterPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->hasAnyShelterRole($user);
    }

    public function view(User $user, ActivationShelter $activationShelter): bool
    {
        return $this->hasAnyShelterRole($user);
    }

    public function open(User $user, ActivationShelter $activationShelter): bool
    {
        return $this->hasShelterRole($user, [
            'Shelter Board Admin',
            'Shelter Manager',
        ]);
    }

    public function close(User $user, ActivationShelter $activationShelter): bool
    {
        return $this->hasShelterRole($user, [
            'Shelter Board Admin',
            'Shelter Manager',
        ]);
    }

    public function submitCensus(User $user, ActivationShelter $activationShelter): bool
    {
        return $this->hasShelterRole($user, [
            'Shelter Board Admin',
            'Shelter Manager',
            'Shelter Staff',
        ]);
    }

    public function addOperationalLog(User $user, ActivationShelter $activationShelter): bool
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
