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

        // Create permissions
        $permissions = [
            'view_plant', 'view_any_plant', 'create_plant', 'update_plant', 'delete_plant', 'delete_any_plant',
            'view_role', 'view_any_role', 'create_role', 'update_role', 'delete_role', 'delete_any_role',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create super_admin role with all permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Create admin role
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'view_plant', 'view_any_plant', 'create_plant', 'update_plant', 'delete_plant', 'delete_any_plant',
        ]);

        // Create editor role
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $editor->givePermissionTo([
            'view_plant', 'view_any_plant', 'create_plant', 'update_plant',
        ]);

        // Create or update admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@verdant.vn'],
            [
                'name' => 'Admin Verdant',
                'password' => Hash::make('password'),
            ]
        );
        $adminUser->assignRole('super_admin');

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Admin login: admin@verdant.vn / password');
    }
}
