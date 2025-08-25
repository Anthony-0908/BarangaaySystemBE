<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Defining Permissions 
        $permissions = [
            'view reports',
            'create users',
            'edit users',
            'delete users',
            'manage finances',
        ];

        foreach ($permissions as $permission) 
        {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles 
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $secretary = Role::firstOrCreate(['name' => 'Secretary']);
        $treasurer = Role::firstOrCreate(['name' => 'Treasurer']);
        $councilor = Role::firstOrCreate(['name' => 'Councilor']);

            // Assign permissions
        $admin->givePermissionTo(Permission::all());

        $secretary->givePermissionTo(['view reports']);
        $treasurer->givePermissionTo(['view reports', 'manage finances']);
        $councilor->givePermissionTo(['view reports']);

    }
}
