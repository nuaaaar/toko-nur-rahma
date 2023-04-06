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
        User::factory()->create([
            'name' => 'Pimpinan CV. Nur Rahma',
            'email' => 'pimpinan@nurrahma.co.id'
        ]);

        User::factory()->create([
            'name' => 'Yanuar Fabien',
            'email' => 'yanuar.fabien.yf@gmail.com'
        ]);

        User::factory()->create([
            'name' => 'Yanuar Fabien',
            'email' => '10191089@student.itk.ac.id'
        ]);
    }
}
