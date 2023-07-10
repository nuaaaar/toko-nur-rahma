<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use App\Services\Customer\CustomerService;
use App\Services\PurchaseOrder\PurchaseOrderService;
use App\Services\PurchaseOrderItem\PurchaseOrderItemService;
use Illuminate\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    protected $user;

    protected $bank;

    protected $existingProduct;

    protected $customer;

    public function __construct(
        protected PurchaseOrderService $purchaseOrderService,
        protected PurchaseOrderItemService $purchaseOrderItemService,
        protected CustomerService $customerService
    ) {
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
            "status" => "menunggu",
            "customer" => [
                "phone_number" => "0859106975837",
                "name" => "Yanuar Fabien",
                "address" => "Jl. Penggalang, Damai"
            ],
            "date" => date('Y-m-d'),
            "purchase_order_items" => [
                [
                    "product_id" => $this->existingProduct->id,
                    "qty" => 1,
                    "selling_price" => $this->existingProduct->selling_price,
                    "selling_price_total" => 1 * $this->existingProduct->selling_price
                ]
            ],
            "total" => 1 * $this->existingProduct->selling_price,
        ]);

        $customer = $this->customerService->updateOrCreateCustomer($request->customer);

        $request['status'] = 'menunggu';
        $request['customer_id'] = $customer->id;

        $purchaseOrder = $this->purchaseOrderService->create($request->except('customer', 'purchase_order_items'));

        $this->purchaseOrderItemService->insertPurchaseOrderItems($request->purchase_order_items, $purchaseOrder->id);
    }
}
