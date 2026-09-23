<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            // Dashboard
            'dashboard.view',

            // Books
            'books.view',
            'books.create',
            'books.edit',
            'books.delete',
            'books.export',
            'books.import',

            // Categories
            'categories.view',
            'categories.create',
            'categories.edit',
            'categories.delete',

            // Publishers
            'publishers.view',
            'publishers.create',
            'publishers.edit',
            'publishers.delete',

            // Racks
            'racks.view',
            'racks.create',
            'racks.edit',
            'racks.delete',

            // Members
            'members.view',
            'members.create',
            'members.edit',
            'members.delete',
            'members.export',

            // Visitors
            'visitors.view',
            'visitors.create',
            'visitors.edit',
            'visitors.delete',
            'visitors.export',

            // Borrowings
            'borrowings.view',
            'borrowings.create',
            'borrowings.edit',
            'borrowings.delete',

            // Returns
            'returns.view',
            'returns.create',
            'returns.edit',

            // Reports
            'reports.view',
            'reports.export',

            // Users
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Roles
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',

            // Permissions
            'permissions.view',

            // Settings
            'settings.view',
            'settings.edit',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $pustakawanRole = Role::create(['name' => 'pustakawan']);
        $pustakawanRole->givePermissionTo([
            'dashboard.view',
            'books.view', 'books.create', 'books.edit', 'books.export', 'books.import',
            'categories.view', 'categories.create', 'categories.edit',
            'publishers.view', 'publishers.create', 'publishers.edit',
            'racks.view', 'racks.create', 'racks.edit',
            'members.view', 'members.create', 'members.edit', 'members.export',
            'visitors.view', 'visitors.create', 'visitors.edit', 'visitors.delete', 'visitors.export',
            'borrowings.view', 'borrowings.create', 'borrowings.edit',
            'returns.view', 'returns.create', 'returns.edit',
            'reports.view', 'reports.export',
        ]);
    }
}
