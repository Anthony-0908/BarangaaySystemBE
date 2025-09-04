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
                'first_name' => 'Test Barangay ',
                'last_name' => ' Captain Admin',
                'password' => bcrypt('Password@123')
            ]
        );
         $admin->assignRole('Admin');

         
        $secretary = User::firstOrCreate(
            ['email' => 'BRSecretary@yopmail.com'],
            [
                'first_name' => 'Test Barangay ',
                'last_name' => 'Secretary',
                'password' => bcrypt('Password@123')
            ]
        );
         $secretary->assignRole('secretary');

            
        $treasurer = User::firstOrCreate(
            ['email' => 'BRtreasurer@yopmail.com'],
            [
                'first_name' => 'Test Barangay ',
                'last_name' => 'Treasurer',
                'password' => bcrypt('Password@123')
            ]
        );
         $treasurer->assignRole('treasurer');

         $councilor = User::firstOrCreate(
            ['email' => 'BRcouncilor@yopmail.com'],
            [
                'first_name' => 'Test Barangay ',
                'last_name' => 'Councilor',
                'password' => bcrypt('Password@123'),
            ]
        );
        $councilor->assignRole('councilor');

    


    }
}
