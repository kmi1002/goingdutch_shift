<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        Permission::create(['name' => 'administrator']);
        Permission::create(['name' => 'manager']);
        Permission::create(['name' => 'operator']);
        Permission::create(['name' => 'analyst']);
        Permission::create(['name' => 'user']);
        Permission::create(['name' => 'vendor_administrator']);
        Permission::create(['name' => 'vendor_manager']);
        Permission::create(['name' => 'vendor_operator']);
        Permission::create(['name' => 'vendor_analyst']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'manager']);
        $role->givePermissionTo(['manager']);

        $role = Role::create(['name' => 'operator']);
        $role->givePermissionTo(['operator']);

        $role = Role::create(['name' => 'analyst']);
        $role->givePermissionTo('analyst');

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo(['user']);

        $role = Role::create(['name' => 'vendor_administrator']);
        $role->givePermissionTo(['vendor_administrator']);

        $role = Role::create(['name' => 'vendor_manager']);
        $role->givePermissionTo(['vendor_manager']);

        $role = Role::create(['name' => 'vendor_operator']);
        $role->givePermissionTo(['vendor_operator']);

        $role = Role::create(['name' => 'vendor_analyst']);
        $role->givePermissionTo('vendor_analyst');
    }
}
