<?php

namespace Tests\Unit;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US46_FilterSaleTest extends TestCase
{
    use RefreshDatabase;

    protected $customer;

    protected $user;

    protected $category;

    protected $bank;

    protected $existingProduct;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed('RoleAndPermissionSeeder');
        $this->category = Category::create(['name' => 'ATK']);

        $this->user = User::factory()->create([
            'email' => 'user@nurrahma.test'
        ]);

        $this->bank = Bank::create([
            'name' => 'BNI',
            'account' => '1234567890',
            'account_name' => 'CV. Nur Rahma'
        ]);

        $this->existingProduct = Product::create([
            'name' => 'Pensil',
            'category_id' => $this->category->id,
            'product_code' => '00001',
            'barcode' => null,
            'unit' => 'PCS',
            'capital_price' => '70000',
            'selling_price' => '150000',
        ]);

        $this->user->assignRole('Pimpinan');

        $this->customer = Customer::create([
            'name' => 'Yanuar Fabien',
            'phone_number' => '081234567890',
            'address' => 'Jl. Raya No. 1'
        ]);

        $data = [
            "_token" => csrf_token(),
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
        ];

        $this->actingAs($this->user)
            ->post('/dashboard/sale', $data);
    }

    public function test_user_can_filter_sale_by_date()
    {
        $this->user->syncRoles(['Pimpinan']);

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.sale.index', ['filters' => ['date_from' => date('Y-m-d'), 'date_to' => date('Y-m-d')]]))
            ->assertSee('INV/' . date('Y/m/d') . '/000001');
    }

    public function test_user_can_filter_sale_by_customer_name()
    {
        $this->user->syncRoles(['Pimpinan']);

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.sale.index', ['filters' => ['customer_id' => $this->customer->id]]))
            ->assertSee($this->customer->name);
    }
}
