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
                'customers.read', 'customers.create', 'customers.update', 'customers.delete',
                'banks.read', 'banks.create', 'banks.update', 'banks.delete',
                'products.read', 'products.create', 'products.update', 'products.delete',
                'procurements.read', 'procurements.create', 'procurements.update', 'procurements.delete',
                'sales.read', 'sales.create', 'sales.update', 'sales.delete',
                'purchase-orders.read', 'purchase-orders.create', 'purchase-orders.update', 'purchase-orders.delete', 'purchase-orders.change-status',
                'delivery-orders.read', 'delivery-orders.create', 'delivery-orders.update', 'delivery-orders.delete',
                'customer-returns.read', 'customer-returns.create', 'customer-returns.update', 'customer-returns.delete',
                'stock-opnames.read', 'stock-opnames.create', 'stock-opnames.update', 'stock-opnames.delete',
                'product-stocks.read',
                'empty-product-stocks.read',
                'profit-losses.read',
                'backup-data.read',
                'import-data.read', 'import-data.create'
            ],
            'Admin Pembukuan' => [
                'suppliers.read', 'suppliers.create', 'suppliers.update', 'suppliers.delete',
                'customers.read', 'customers.create', 'customers.update', 'customers.delete',
                'banks.read', 'banks.create', 'banks.update', 'banks.delete',
                'products.read', 'products.create', 'products.update', 'products.delete',
                'procurements.read', 'procurements.create', 'procurements.update', 'procurements.delete',
                'sales.read',
                'purchase-orders.read', 'purchase-orders.update',
                'delivery-orders.read', 'delivery-orders.update',
                'customer-returns.read', 'customer-returns.create', 'customer-returns.update', 'customer-returns.delete',
                'stock-opnames.read', 'stock-opnames.create', 'stock-opnames.update', 'stock-opnames.delete',
                'product-stocks.read',
                'import-data.read', 'import-data.create',
                'backup-data.read',
                'profit-losses.read',
            ],
            'Marketing' => [
                'purchase-orders.read', 'purchase-orders.create',
            ],
            'Kepala Gudang' => [
                'purchase-orders.read', 'purchase-orders.change-status',
                'stock-opnames.read', 'stock-opnames.create',
                'product-stocks.read',
                'empty-product-stocks.read',
            ],
            'Admin Penjualan' => [
                'purchase-orders.read', 'purchase-orders.change-status',
                'sales.read', 'sale.create',
                'delivery-orders.read', 'delivery-orders.create', 'delivery-orders.update',
            ],
            'Akuntan' => [
                'purchase-orders.read',
                'sales.read',
                'profit-losses.read',
                'backup-data.read',
            ],
        ];

        $insertPermissions = function ($role) use ($permissionsByRole) {
            return collect($permissionsByRole[$role])
                ->map(fn ($name) => DB::table('permissions')->where('name', $name)->first()->id ?? DB::table('permissions')->insertGetId(['name' => $name, 'guard_name' => 'web']))
                ->toArray();
        };

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
