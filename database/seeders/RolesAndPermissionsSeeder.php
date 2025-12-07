<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        $authUserRole = Role::create(['name' => 'authuser']);

        // Create permissions
        $adminPermissions = [
            '/',
            '/Home',
            '/Destination',
            '/About',
            '/Login',
            '/Signup',
            '/admin-panel',
            '/admin-panel/contacts-reviews',
        ];

        $userPermissions = [
            '/',
            '/Home',
            '/Destination',
            '/About',
            '/Signup',
            '/Login',
            // Add more user permissions as needed
        ];

        $authUserPermissions = [
            '/',
            '/Home',
            '/Destination',
            '/About',
            '/postad',
            '/myads',
            '/purchased-ads',
            '/user-update',
            '/user-receipt',
        ];

        foreach ($adminPermissions as $permission) {
            Permission::create(['name' => $permission]);
            $adminRole->givePermissionTo($permission);
        }

        foreach ($userPermissions as $permission) {
            Permission::create(['name' => $permission]);
            $userRole->givePermissionTo($permission);
        }

        foreach ($authUserPermissions as $permission) {
            Permission::create(['name' => $permission]);
            $authUserRole->givePermissionTo($permission);
        }
    }

}
