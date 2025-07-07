<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Define roles
        $roles = [
            'policy_holder',
            'company_official',
            'administrator',
            'agent',
        ];

        // Define permissions
        $permissions = [
            'view_policies', 'create_policies', 'update_policies', 'delete_policies',
            'process_payments', 'view_payments',
            'manage_claims', 'approve_claims',
            'generate_reports', 'view_reports',
            'manage_users', 'manage_system',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        foreach ($roles as $role) {
            $roleModel = Role::firstOrCreate(['name' => $role]);
            if ($role === 'administrator') {
                $roleModel->syncPermissions($permissions);
            }
        }
    }
}
