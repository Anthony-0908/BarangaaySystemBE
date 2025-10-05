<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Create roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $secretaryRole = Role::firstOrCreate(['name' => 'Secretary']);
        $treasurerRole = Role::firstOrCreate(['name' => 'Treasurer']);
        $councilorRole = Role::firstOrCreate(['name' => 'Councilor']);

        // ✅ Create Admin user
        $admin = User::firstOrCreate(
            ['email' => 'BRadmin@yopmail.com'],
            [
                'first_name' => 'Test Barangay',
                'last_name' => 'Captain Admin',
                'password' => bcrypt('Password@123'),
            ]
        );
        $admin->assignRole($adminRole);

        // ✅ Create Secretary user
        $secretary = User::firstOrCreate(
            ['email' => 'BRSecretary@yopmail.com'],
            [
                'first_name' => 'Test Barangay',
                'last_name' => 'Secretary',
                'password' => bcrypt('Password@123'),
            ]
        );
        $secretary->assignRole($secretaryRole);

        // ✅ Create Treasurer user
        $treasurer = User::firstOrCreate(
            ['email' => 'BRTreasurer@yopmail.com'],
            [
                'first_name' => 'Test Barangay',
                'last_name' => 'Treasurer',
                'password' => bcrypt('Password@123'),
            ]
        );
        $treasurer->assignRole($treasurerRole);

        // ✅ Create Councilor user
        $councilor = User::firstOrCreate(
            ['email' => 'BRCouncilor@yopmail.com'],
            [
                'first_name' => 'Test Barangay',
                'last_name' => 'Councilor',
                'password' => bcrypt('Password@123'),
            ]
        );
        $councilor->assignRole($councilorRole);
    }
}
