<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leader = User::factory()->create([
            'name' => 'Maulana Agus Harianto',
            'email' => 'maulana.agus@example.test'
        ]);
        $leader->assignRole('Pimpinan');

        $leader = User::factory()->create([
            'name' => 'Nur Khalifa',
            'email' => 'nur.khalifa@example.test'
        ]);
        $leader->assignRole('Pimpinan');

        $leader = User::factory()->create([
            'name' => 'Hj. Agus Sunoto',
            'email' => 'agus.sunoto@example.test'
        ]);
        $leader->assignRole('Pimpinan');

        $bookkeeping = User::factory()->create([
            'name' => 'Tyas',
            'email' => 'tyas@example.test'
        ]);
        $bookkeeping->assignRole('Admin Pembukuan');

        $marketing = User::factory()->create([
            'name' => 'MuhammadRahmatullah',
            'email' => 'm.rahmatullah@example.test'
        ]);
        $marketing->assignRole('Marketing');

        $warehouse = User::factory()->create([
            'name' => 'Misfaudin',
            'email' => 'misfaudin@example.test'
        ]);
        $warehouse->assignRole('Kepala Gudang');

        $sales = User::factory()->create([
            'name' => 'Siti May Sarah',
            'email' => 'siti@example.test'
        ]);
        $sales->assignRole('Admin Penjualan');

        $accounting = User::factory()->create([
            'name' => 'Lisa meidina',
            'email' => 'lisa@example.test'
        ]);
        $accounting->assignRole('Akuntan');

        $superadmin = User::factory()->create([
            'name' => 'Yanuar Fabien',
            'email' => 'yanuar.fabien.yf@gmail.com'
        ]);
        $superadmin->assignRole('Superadmin');
    }
}
