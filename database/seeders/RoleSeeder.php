<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // =============================================
        // Shield permissions for ALL Filament resources
        // =============================================
        $resourcePermissions = [
            // PlantResource
            'view_plant', 'view_any_plant', 'create_plant', 'update_plant',
            'delete_plant', 'delete_any_plant', 'force_delete_plant', 'force_delete_any_plant',
            'restore_plant', 'restore_any_plant', 'reorder_plant',

            // OrderResource
            'view_order', 'view_any_order', 'create_order', 'update_order',
            'delete_order', 'delete_any_order', 'force_delete_order', 'force_delete_any_order',
            'restore_order', 'restore_any_order', 'reorder_order',

            // GiftCodeResource
            'view_gift::code', 'view_any_gift::code', 'create_gift::code', 'update_gift::code',
            'delete_gift::code', 'delete_any_gift::code', 'force_delete_gift::code', 'force_delete_any_gift::code',
            'restore_gift::code', 'restore_any_gift::code', 'reorder_gift::code',

            // UserResource
            'view_user', 'view_any_user', 'create_user', 'update_user',
            'delete_user', 'delete_any_user', 'force_delete_user', 'force_delete_any_user',
            'restore_user', 'restore_any_user', 'reorder_user',

            // RoleResource (Shield)
            'view_role', 'view_any_role', 'create_role', 'update_role',
            'delete_role', 'delete_any_role', 'force_delete_role', 'force_delete_any_role',
            'restore_role', 'restore_any_role', 'reorder_role',

            // Pages
            'page_Analytics',
        ];

        foreach ($resourcePermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // =============================================
        // Create super_admin role with ALL permissions
        // =============================================
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // Create admin role (limited permissions)
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions([
            'view_plant', 'view_any_plant', 'create_plant', 'update_plant', 'delete_plant', 'delete_any_plant',
            'view_order', 'view_any_order', 'update_order',
            'view_gift::code', 'view_any_gift::code', 'create_gift::code', 'update_gift::code',
            'view_user', 'view_any_user',
            'page_Analytics',
        ]);

        // Create editor role
        $editor = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $editor->syncPermissions([
            'view_plant', 'view_any_plant', 'create_plant', 'update_plant',
        ]);

        // =============================================
        // Create or update admin user
        // =============================================
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@verdant.vn'],
            [
                'name' => 'Admin Verdant',
                'password' => Hash::make('password'),
            ]
        );
        // Ensure super_admin role is assigned
        if (!$adminUser->hasRole('super_admin')) {
            $adminUser->assignRole('super_admin');
        }

        // Reset permission cache after seeding
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('✅ Roles and permissions seeded successfully!');
        $this->command->info('📧 Admin login: admin@verdant.vn / password');
    }
}
