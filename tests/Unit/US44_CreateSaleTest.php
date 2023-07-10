<?php

namespace Tests\Unit;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US44_CreateSaleTest extends TestCase
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

    public function test_authorized_user_can_access_create_sale_page()
    {
        $this->user->assignRole('Pimpinan');

        $this->actingAs($this->user)
            ->get('/dashboard/sale/create')
            ->assertStatus(200)
            ->assertViewIs('dashboard.sale.create');
    }

    public function test_user_can_create_sale_with_valid_input()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            "_token" => csrf_token(),
            "user_id" => $this->user->id,
            "customer" => [
                "phone_number" => "0859106975837",
                "name" => "Yanuar Fabien"
            ],
            "date" => date('Y-m-d'),
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
            ->post('/dashboard/sale', $data)
            ->assertRedirectToRoute('dashboard.sale.index')
            ->assertSessionHas('success', 'Berhasil menambah data');

        $this->assertDatabaseHas('sales', [
            'invoice_number' => "INV/".date('Y/m/d')."/" . str_pad(1, 6, '0', STR_PAD_LEFT)
        ]);

        $this->assertDatabaseHas('product_stocks', [
            'product_id' => $this->existingProduct->id,
            'stock' => -1
        ]);
    }

    public function test_user_cannot_create_sale_without_required_inputs()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            "_token" => csrf_token(),
            "user_id" => $this->user->id,
        ];

        $this->actingAs($this->user)
            ->post('/dashboard/sale', $data)
            ->assertRedirect()
            ->assertSessionHasErrors('customer.name')
            ->assertSessionHasErrors('customer.phone_number')
            ->assertSessionHasErrors('date')
            ->assertSessionHasErrors('sale_items')
            ->assertSessionHasErrors('payment_method')
            ->assertSessionHasErrors('total')
            ->assertSessionHasErrors('total_paid')
            ->assertSessionHasErrors('total_change');
    }

    public function test_unauthorized_user_cannot_access_create_sale_page()
    {
        $this->user->assignRole('Marketing');

        $this->actingAs($this->user)
            ->get('/dashboard/sale/create')
            ->assertStatus(403);
    }
}
