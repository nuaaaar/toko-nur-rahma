<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US37_FilterPurchaseOrderTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $category;

    protected $customer;

    protected $existingProduct;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed('RoleAndPermissionSeeder');
        $this->category = Category::create(['name' => 'ATK']);

        $this->user = User::factory()->create([
            'email' => 'user@nurrahma.test'
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

        $this->user->assignRole('Pimpinan');

        $data = [
            "_token" => csrf_token(),
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
            "total_change" => null
        ];


        $this->actingAs($this->user)
            ->post('/dashboard/purchase-order', $data);
    }

    public function test_user_can_filter_purchase_order_by_date()
    {
        $this->user->syncRoles(['Pimpinan']);

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.purchase-order.index', ['filters' => ['date_from' => date('Y-m-d'), 'date_to' => date('Y-m-d')]]))
            ->assertSee('PO/' . date('Y/m/d') . '/000001');
    }

    public function test_user_can_filter_purchase_order_by_customer_name()
    {
        $this->user->syncRoles(['Pimpinan']);

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.purchase-order.index', ['filters' => ['customer_id' => $this->customer->id]]))
            ->assertSee($this->customer->name);
    }

    public function test_user_can_filter_purchase_order_by_status()
    {
        $this->user->syncRoles(['Pimpinan']);

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.purchase-order.index', ['filters' => ['status' => 'menunggu']]))
            ->assertSee('menunggu');
    }
}
