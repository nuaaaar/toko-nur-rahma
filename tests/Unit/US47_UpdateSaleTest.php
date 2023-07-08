<?php

namespace Tests\Unit;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US47_UpdateSaleTest extends TestCase
{
    use RefreshDatabase;

    protected $customer;

    protected $user;

    protected $category;

    protected $bank;

    protected $existingProduct;

    protected $customerService;

    protected $saleService;

    protected $saleItemService;

    protected $productStockService;

    protected $existingSale;

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

        $this->seed('SaleSeeder');

        $this->existingSale = Sale::first();
    }


    public function test_authorized_user_can_access_edit_sale_page()
    {
        $this->user->assignRole('Pimpinan');

        $this->actingAs($this->user)
            ->get('/dashboard/sale/' . $this->existingSale->id . '/edit')
            ->assertStatus(200)
            ->assertViewIs('dashboard.sale.edit');
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
            "date" => "2023-07-08",
            "sale_items" => [
                [
                    "product_id" => $this->existingProduct->id,
                    "qty" => 2,
                    "selling_price" => $this->existingProduct->selling_price,
                    "selling_price_total" => 2 * $this->existingProduct->selling_price
                ]
            ],
            "payment_method" => "transfer",
            "total_paid" => 2 * $this->existingProduct->selling_price,
            "bank_id" => $this->bank->id,
            "total" => 2 * $this->existingProduct->selling_price,
            "total_change" => 0
        ];

        $this->actingAs($this->user)
            ->put('/dashboard/sale/' . $this->existingSale->id, $data)
            ->assertRedirectToRoute('dashboard.sale.index')
            ->assertSessionHas('success', 'Berhasil mengubah data');

        $this->assertDatabaseHas('product_stocks', [
            'product_id' => $this->existingProduct->id,
            'stock' => -2
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
            ->put('/dashboard/sale/' . $this->existingSale->id, $data)
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
            ->get('/dashboard/sale/' . $this->existingSale->id . '/edit')
            ->assertStatus(403);
    }
}
