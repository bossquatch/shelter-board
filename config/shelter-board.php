<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Shelter Board Roles
    |--------------------------------------------------------------------------
    |
    | These are simple role names for the exercise-ready version. If you already
    | use Spatie Permission or another role system, map these names to your
    | existing structure instead of creating a second permission circus.
    |
    */

    'roles' => [
        'admin' => 'Shelter Board Admin',
        'manager' => 'Shelter Manager',
        'staff' => 'Shelter Staff',
        'viewer' => 'Shelter Viewer',
    ],

    'permissions' => [
        'view_dashboard',
        'manage_activations',
        'manage_shelters',
        'open_shelters',
        'close_shelters',
        'register_guests',
        'check_out_guests',
        'submit_census',
        'add_operational_logs',
        'view_reports',
    ],
];
