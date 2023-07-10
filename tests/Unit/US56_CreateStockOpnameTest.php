<?php

namespace Tests\Unit;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US56_CreateStockOpnameTest extends TestCase
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

    public function test_authorized_user_can_access_create_stock_opname_page()
    {
        $this->user->assignRole('Pimpinan');

        $this->actingAs($this->user)
            ->get('/dashboard/stock-opname/create')
            ->assertStatus(200)
            ->assertViewIs('dashboard.stock-opname.create');
    }

    public function test_user_can_create_stock_opname_with_valid_input()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            "_token" => csrf_token(),
            "user_id" => $this->user->id,
            "date_from" => date('Y-m-d', strtotime('-7 days')),
            "date_to" => date('Y-m-d'),
            "title" => "SO Pensil",
            "date" => date('Y-m-d'),
            "stock_opname_items" => [
                [
                    "product_id" => $this->existingProduct->id,
                    "physical" => "9",
                    "returned_to_supplier" => "0",
                    "system" => "9",
                    "description" => null
                ]
            ]
        ];

        $this->actingAs($this->user)
            ->post('/dashboard/stock-opname', $data)
            ->assertRedirectToRoute('dashboard.stock-opname.index')
            ->assertSessionHas('success', 'Berhasil menambah data');
    }

    public function test_user_cannot_create_stock_opname_without_required_inputs()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            "_token" => csrf_token(),
            "user_id" => $this->user->id,
        ];

        $this->actingAs($this->user)
            ->post('/dashboard/stock-opname', $data)
            ->assertRedirect()
            ->assertSessionHasErrors('title')
            ->assertSessionHasErrors('date')
            ->assertSessionHasErrors('date_from')
            ->assertSessionHasErrors('date_to')
            ->assertSessionHasErrors('stock_opname_items');
    }

    public function test_unauthorized_user_cannot_access_create_stock_opname_page()
    {
        $this->user->assignRole('Marketing');

        $this->actingAs($this->user)
            ->get('/dashboard/stock-opname/create')
            ->assertStatus(403);
    }
}
