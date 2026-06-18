<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShelterBoardSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('shelters')->insertOrIgnore([
            [
                'name' => 'Bartow Special Needs Shelter',
                'address' => null,
                'municipality' => 'Bartow',
                'county' => 'Polk',
                'region' => 'FDEM Region 4',
                'postal_code' => null,
                'capacity' => 0,
                'special_needs_capacity' => 0,
                'pet_capacity' => 0,
                'ada_compliant' => true,
                'pet_friendly' => false,
                'backup_generator' => false,
                'status' => 'Available',
                'is_active' => true,
                'comments' => 'Seed record. Update with official facility details.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ridge Special Needs Shelter',
                'address' => null,
                'municipality' => null,
                'county' => 'Polk',
                'region' => 'FDEM Region 4',
                'postal_code' => null,
                'capacity' => 0,
                'special_needs_capacity' => 0,
                'pet_capacity' => 0,
                'ada_compliant' => true,
                'pet_friendly' => false,
                'backup_generator' => false,
                'status' => 'Available',
                'is_active' => true,
                'comments' => 'Seed record. Update with official facility details.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tenoroc Special Needs Shelter',
                'address' => null,
                'municipality' => null,
                'county' => 'Polk',
                'region' => 'FDEM Region 4',
                'postal_code' => null,
                'capacity' => 0,
                'special_needs_capacity' => 0,
                'pet_capacity' => 0,
                'ada_compliant' => true,
                'pet_friendly' => false,
                'backup_generator' => false,
                'status' => 'Available',
                'is_active' => true,
                'comments' => 'Seed record. Update with official facility details.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $activationId = DB::table('activations')->insertGetId([
            'name' => 'Special Needs Readiness Exercise 2026',
            'incident_type' => 'Exercise',
            'status' => 'Planned',
            'started_at' => null,
            'ended_at' => null,
            'created_by' => null,
            'updated_by' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $shelters = DB::table('shelters')->where('is_active', true)->get();

        foreach ($shelters as $shelter) {
            DB::table('activation_shelters')->insertOrIgnore([
                'activation_id' => $activationId,
                'shelter_id' => $shelter->id,
                'status' => 'Standby',
                'current_capacity' => $shelter->capacity,
                'current_occupancy' => 0,
                'notes' => 'Seeded for readiness exercise.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
