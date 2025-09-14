<?php

namespace Database\Seeders;

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

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'api']
            );
        }

        // Create Roles with guard_name = api
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'api']);
        $secretary = Role::firstOrCreate(['name' => 'Secretary', 'guard_name' => 'api']);
        $treasurer = Role::firstOrCreate(['name' => 'Treasurer', 'guard_name' => 'api']);
        $councilor = Role::firstOrCreate(['name' => 'Councilor', 'guard_name' => 'api']);

        // Assign permissions
        $admin->givePermissionTo(Permission::all());

        $secretary->givePermissionTo(['view reports']);
        $treasurer->givePermissionTo(['view reports', 'manage finances']);
        $councilor->givePermissionTo(['view reports']);
    }
}
