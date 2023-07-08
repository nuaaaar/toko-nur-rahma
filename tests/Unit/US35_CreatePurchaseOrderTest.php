<?php

namespace Tests\Unit;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US35_CreatePurchaseOrderTest extends TestCase
{
    use RefreshDatabase;

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
    }

    public function test_authorized_user_can_access_create_purchase_order_page()
    {
        $this->user->assignRole('Pimpinan');

        $this->actingAs($this->user)
            ->get('/dashboard/purchase-order/create')
            ->assertStatus(200)
            ->assertViewIs('dashboard.purchase-order.create');
    }

    public function test_user_can_create_sale_with_valid_input()
    {
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
            ->post('/dashboard/purchase-order', $data)
            ->assertRedirectToRoute('dashboard.purchase-order.index')
            ->assertSessionHas('success', 'Berhasil menambah data');

    }

    public function test_user_cannot_create_sale_without_required_inputs()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            "_token" => csrf_token(),
            "user_id" => $this->user->id,
            "status" => "menunggu",
        ];

        $this->actingAs($this->user)
            ->post('/dashboard/purchase-order', $data)
            ->assertRedirect()
            ->assertSessionHasErrors('customer.name')
            ->assertSessionHasErrors('customer.phone_number')
            ->assertSessionHasErrors('customer.address')
            ->assertSessionHasErrors('date')
            ->assertSessionHasErrors('purchase_order_items')
            ->assertSessionHasErrors('total');
    }

    public function test_unauthorized_user_cannot_access_create_purchase_order_page()
    {
        $this->user->assignRole('Admin Pembukuan');

        $this->actingAs($this->user)
            ->get('/dashboard/purchase-order/create')
            ->assertStatus(403);
    }
}
