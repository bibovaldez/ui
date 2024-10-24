<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view_transactions',
            'create_transactions',
            'edit_transactions',
            'delete_transactions',
            'manage_roles',
            'manage_permissions',
            'manage_users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = Role::create(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $subAdmin = Role::create(['name' => 'sub_admin']);
        $subAdmin->givePermissionTo(['view_transactions', 'create_transactions','manage_users']);

        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo(['view_transactions','create_transactions']);
    }
}