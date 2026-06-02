<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Creates default roles and a super admin user.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create permissions
        $permissions = [
            // Product permissions
            'view_any_product',
            'view_product',
            'create_product',
            'update_product',
            'delete_product',
            'delete_any_product',
            'reorder_product',

            // Brand permissions
            'view_any_brand',
            'view_brand',
            'create_brand',
            'update_brand',
            'delete_brand',
            'delete_any_brand',
            'reorder_brand',

            // User permissions
            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
            'delete_user',
            'delete_any_user',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->syncPermissions([
            'view_any_product',
            'view_product',
            'create_product',
            'update_product',
            'delete_product',
            'delete_any_product',
            'reorder_product',

            'view_any_brand',
            'view_brand',
            'create_brand',
            'update_brand',
            'delete_brand',
            'delete_any_brand',
            'reorder_brand',

            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
        ]);

        $userRole->syncPermissions([
            'view_any_product',
            'view_product',
            'view_any_brand',
            'view_brand',
        ]);

        // Super admin gets all permissions via Gate::before in AuthServiceProvider

        // Create super admin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'it_support@interprima.co.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('@28Mei1998Tio'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // Create a regular admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@catalog.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);

        // Create a regular user
        $user = User::firstOrCreate(
            ['email' => 'user@catalog.com'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $user->assignRole($userRole);

    }
}
