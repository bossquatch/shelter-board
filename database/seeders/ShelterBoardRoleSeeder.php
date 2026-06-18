<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShelterBoardRoleSeeder extends Seeder
{
    public function run(): void
    {
        /*
         * This seeder supports Spatie Laravel Permission if it exists.
         * If your app uses a different role system, use these role names
         * as the source list and map them there.
         */
        if (! class_exists(\Spatie\Permission\Models\Role::class)) {
            return;
        }

        $roles = [
            'Shelter Board Admin',
            'Shelter Manager',
            'Shelter Staff',
            'Shelter Viewer',
        ];

        $permissions = [
            'view shelter board',
            'manage shelter activations',
            'manage shelters',
            'open shelters',
            'close shelters',
            'register shelter guests',
            'check out shelter guests',
            'submit shelter census',
            'add shelter operational logs',
            'view shelter reports',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $admin = \Spatie\Permission\Models\Role::firstOrCreate([
            'name' => 'Shelter Board Admin',
            'guard_name' => 'web',
        ]);
        $admin->syncPermissions($permissions);

        $manager = \Spatie\Permission\Models\Role::firstOrCreate([
            'name' => 'Shelter Manager',
            'guard_name' => 'web',
        ]);
        $manager->syncPermissions([
            'view shelter board',
            'open shelters',
            'close shelters',
            'register shelter guests',
            'check out shelter guests',
            'submit shelter census',
            'add shelter operational logs',
            'view shelter reports',
        ]);

        $staff = \Spatie\Permission\Models\Role::firstOrCreate([
            'name' => 'Shelter Staff',
            'guard_name' => 'web',
        ]);
        $staff->syncPermissions([
            'view shelter board',
            'register shelter guests',
            'check out shelter guests',
            'submit shelter census',
            'add shelter operational logs',
        ]);

        $viewer = \Spatie\Permission\Models\Role::firstOrCreate([
            'name' => 'Shelter Viewer',
            'guard_name' => 'web',
        ]);
        $viewer->syncPermissions([
            'view shelter board',
            'view shelter reports',
        ]);
    }
}
