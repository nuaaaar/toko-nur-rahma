<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockOpname;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US59_DeleteStockOpnameTest extends TestCase
{
    use RefreshDatabase;

    protected $customer;

    protected $user;

    protected $category;

    protected $existingProduct;

    protected $customerService;

    protected $purchaseOrderService;

    protected $purchaseOrderItemService;

    protected $productStockService;

    protected $existingStockOpname;

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

        $this->seed('StockOpnameSeeder');

        $this->existingStockOpname = StockOpname::with(['stockOpnameItems.product', 'user'])->first();
    }


    public function test_authorized_user_can_delete_stock_opname()
    {
        $this->user->assignRole('Pimpinan');

        $this->actingAs($this->user)
            ->delete('/dashboard/stock-opname/' . $this->existingStockOpname->id)
            ->assertRedirectToRoute('dashboard.stock-opname.index')
            ->assertSessionHas('success', 'Berhasil menghapus data');
    }

    public function test_unauthorized_user_cannot_delete_stock_opname()
    {
        $this->user->assignRole('Marketing');

        $this->actingAs($this->user)
            ->delete('/dashboard/stock-opname/' . $this->existingStockOpname->id)
            ->assertStatus(403);
    }
}
