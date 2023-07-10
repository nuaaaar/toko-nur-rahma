<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Services\ProductStock\ProductStockService;
use App\Services\StockOpname\StockOpnameService;
use App\Services\StockOpnameItem\StockOpnameItemService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Log;

class StockOpnameSeeder extends Seeder
{
    protected $productStockService;

    protected $stockOpnameService;

    protected $stockOpnameItemService;

    protected $user;

    protected $existingProduct;

    public function __construct(ProductStockService $productStockService, StockOpnameService $stockOpnameService, StockOpnameItemService $stockOpnameItemService)
    {
        $this->productStockService = $productStockService;
        $this->stockOpnameService = $stockOpnameService;
        $this->stockOpnameItemService = $stockOpnameItemService;

        $this->user = User::factory()->create([
            'email' => 'user@nurrahma.test'
        ]);

        $this->user->assignRole('Pimpinan');

        $this->existingProduct = Product::first();
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $request = new \Illuminate\Http\Request();
        $request->replace([
            "user_id" => $this->user->id,
            "date_from" => date('Y-m-d', strtotime('-7 days')),
            "date_to" => date('Y-m-d'),
            "title" => "SO Pensil",
            "date" => date('Y-m-d'),
            "stock_opname_items" => [
                [
                    "product_id" => $this->existingProduct->id,
                    "physical" => 9,
                    "returned_to_supplier" => 0,
                    "system" => 9,
                    "description" => null
                ]
            ]
        ]);

        $stockOpname = $this->stockOpnameService->create($request->except('stock_opname_items'));

        $this->stockOpnameItemService->insertStockOpnameItems($request->stock_opname_items, $stockOpname->id);
    }
}
