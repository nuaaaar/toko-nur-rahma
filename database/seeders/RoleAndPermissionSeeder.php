<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            'Superadmin',
            'Pimpinan',
            'Admin Pembukuan',
            'Marketing',
            'Kepala Gudang',
            'Admin Penjualan',
            'Akuntan',
        ];

        collect($roles)
            ->map(fn ($name) => DB::table('roles')->insertGetId(['name' => $name, 'guard_name' => 'web']))
            ->toArray();

        $permissionsByRole = [
            'Pimpinan' => [
                'roles.read', 'roles.create', 'roles.update', 'roles.delete',
                'users.read', 'users.create', 'users.update', 'users.delete',
                'suppliers.read', 'suppliers.create', 'suppliers.update', 'suppliers.delete',
            ],
            'Admin Pembukuan' => [],
            'Marketing' => [],
            'Kepala Gudang' => [],
            'Admin Penjualan' => [],
            'Akuntan' => [],
        ];

        $insertPermissions = fn ($role) => collect($permissionsByRole[$role])
            ->map(fn ($name) => DB::table('permissions')->insertGetId(['name' => $name, 'guard_name' => 'web']))
            ->toArray();

        $permissionIdsByRole = [
            'Pimpinan' => $insertPermissions('Pimpinan'),
            'Admin Pembukuan' => $insertPermissions('Admin Pembukuan'),
            'Marketing' => $insertPermissions('Marketing'),
            'Kepala Gudang' => $insertPermissions('Kepala Gudang'),
            'Admin Penjualan' => $insertPermissions('Admin Penjualan'),
            'Akuntan' => $insertPermissions('Akuntan'),
        ];

        foreach ($permissionIdsByRole as $role => $permissionIds) {
            $role = Role::whereName($role)->first();

            DB::table('role_has_permissions')
                ->insert(
                    collect($permissionIds)->map(fn ($id) => [
                        'role_id' => $role->id,
                        'permission_id' => $id
                    ])->toArray()
                );
        }
    }
}
