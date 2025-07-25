<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $browsePermission = Permission::create(['name' => 'browse_permission']);
        $viewPermission = Permission::create(['name' => 'view_permission']);
        $createPermission = Permission::create(['name' => 'create_permission']);
        $updatePermission = Permission::create(['name' => 'update_permission']);
        $deletePermission = Permission::create(['name' => 'delete_permission']);

        $browseRole = Permission::create(['name' => 'browse_role']);
        $viewRole = Permission::create(['name' => 'view_role']);
        $createRole = Permission::create(['name' => 'create_role']);
        $updateRole = Permission::create(['name' => 'update_role']);
        $deleteRole = Permission::create(['name' => 'delete_role']);

        $browseUser = Permission::create(['name' => 'browse_user']);
        $viewUser = Permission::create(['name' => 'view_user']);
        $createUser = Permission::create(['name' => 'create_user']);
        $updateUser = Permission::create(['name' => 'update_user']);
        $deleteUser = Permission::create(['name' => 'delete_user']);

      
        $browsecCategory = Permission::create(['name' => 'browse_category']);
        $viewCategory = Permission::create(['name' => 'view_category']);
        $createCategory = Permission::create(['name' => 'create_category']);
        $updateCategory = Permission::create(['name' => 'update_category']);
        $deleteCategory = Permission::create(['name' => 'delete_category']);


        // create roles and assign existing permissions
        $roleSuperAdmin = Role::create(['guard_name'=>'web', 'name'=>'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        $roleAdmin = Role::create(['guard_name'=>'web', 'name'=>'admin']);
        $roleAdmin->givePermissionTo([$browseUser, $viewUser, $createUser, $updateUser, $deleteUser]);

        $roleUser = Role::create(['guard_name'=>'web', 'name'=>'user']);
        $roleUser->givePermissionTo([]);

        $roleEmployee = Role::create(['guard_name'=>'barber', 'name'=>'employee']);
        $roleEmployee->givePermissionTo([]);

        // create demo users
        $superAdmin = \App\Models\User::create([
            'name' => 'super-admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('pass@123'),
            'mobileno' => 1234567899,
            'gender' => 1,
            'status' => 1,
        ]);
        $superAdmin->assignRole($roleSuperAdmin);

        $admin = \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('pass@123'),
            'mobileno' => 1234567899,
            'gender' => 1,
            'status' => 1,
        ]);
        $admin->assignRole($roleAdmin);

        $user = \App\Models\User::create([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('pass@123'),
            'mobileno' => 1234567899,
            'gender' => 1,
            'status' => 1,
        ]);
        $user->assignRole($roleUser);
    }
}
