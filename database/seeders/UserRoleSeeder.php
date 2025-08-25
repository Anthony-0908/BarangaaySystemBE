<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder; 
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $secretaryRole = Role::firstOrCreate(['name' => 'Secretary']);
        $treasuerRole = Role::firstOrCreate(['name' => 'Treasurer']);
        $councilorRole = Role::firstOrCreate(['name' => 'Councilor']);

        $admin = User::firstOrCreate(
            ['email' => 'BRadmin@yopmail.com'],
            [
                'name' => 'Test Barangay Captain Admin',
                'password' => bcrypt('Password@123')
            ]
        );
         $admin->assignRole('Admin');

         
        $secretary = User::firstOrCreate(
            ['email' => 'BRSecretary@yopmail.com'],
            [
                'name' => 'Test Barangay Secretary',
                'password' => bcrypt('Password@123')
            ]
        );
         $secretary->assignRole('secretary');

            
        $treasurer = User::firstOrCreate(
            ['email' => 'BRtreasurer@yopmail.com'],
            [
                'name' => 'Test Barangay treasurer',
                'password' => bcrypt('Password@123')
            ]
        );
         $treasurer->assignRole('treasurer');

         $councilor = User::firstOrCreate(
            ['email' => 'BRcouncilor@yopmail.com'],
            [
                'name' => 'Test Barangay councilor',
                'password' => bcrypt('Password@123'),
            ]
        );
        $councilor->assignRole('councilor');

    


    }
}
