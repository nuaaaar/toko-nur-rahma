<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use App\Services\Customer\CustomerService;
use App\Services\ProductStock\ProductStockService;
use App\Services\Sale\SaleService;
use App\Services\SaleItem\SaleItemService;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Log;

class SaleSeeder extends Seeder
{
    protected $category;

    protected $user;

    protected $bank;

    protected $existingProduct;

    protected $customer;

    public function __construct(
        private CustomerService $customerService,
        private SaleService $saleService,
        private ProductStockService $productStockService,
        private SaleItemService $saleItemService,
    ){
        $this->category = Category::create(['name' => 'ATK']);

        $this->user = User::factory()->create([
            'email' => 'user@nurrahma.test'
        ]);

        $this->bank = Bank::create([
            'name' => 'BNI',
            'account' => '1234567890',
            'account_name' => 'CV. Nur Rahma'
        ]);

        $this->existingProduct = Product::first();

        $this->user->assignRole('Pimpinan');

        $this->customer = Customer::create([
            'name' => 'Yanuar Fabien',
            'phone_number' => '081234567890',
            'address' => 'Jl. Raya No. 1'
        ]);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $request = new \Illuminate\Http\Request();
        $request->replace([
            "user_id" => $this->user->id,
            "customer" => $this->customer->only(['name', 'phone_number']),
            "date" => "2023-07-08",
            "sale_items" => [
                [
                    "product_id" => $this->existingProduct->id,
                    "qty" => 1,
                    "selling_price" => $this->existingProduct->selling_price,
                    "selling_price_total" => 1 * $this->existingProduct->selling_price
                ]
            ],
            "payment_method" => "cash",
            "total_paid" => "400000",
            "bank_id" => $this->bank->id,
            "total" => 1 * $this->existingProduct->selling_price,
            "total_change" => 0
        ]);

        $customer = $this->customerService->updateOrCreateCustomer($request->customer);

        $request['customer_id'] = $customer->id;

        $sale = $this->saleService->create($request->except('customer', 'sale_items'));

        $this->productStockService->upsertProductStocksFromEveryProductByDate('sale', null, $request->date, null, $request->sale_items);

        $this->saleItemService->insertSaleItems($request->sale_items, $sale->id);
    }
}
