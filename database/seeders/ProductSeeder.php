<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'KALKULATOR CASIO DH-16',
                'product_code' => '00002',
                'barcode' => null,
                'unit' => 'PCS',
                'capital_price' => 250000,
                'selling_price' => 325350,
                'category_id' => 1,
                'created_at' => '2021-05-22 12:50:00',
                'updated_at' => '2021-05-22 12:50:00'
            ],
            [
                'name' => 'BUKU TULIS DODO 30',
                'product_code' => '00019',
                'barcode' => null,
                'unit' => 'PAK',
                'capital_price' => 15000,
                'selling_price' => 18900,
                'category_id' => 1,
                'created_at' => '2021-05-22 12:50:00',
                'updated_at' => '2021-05-22 12:50:00'
            ],

        ];

        Product::insert($products);
    }
}
