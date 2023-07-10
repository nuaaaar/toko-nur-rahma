<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US36_ReadPurchaseOrderTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $category;

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
    }

    public function test_authorized_user_can_read_purchase_order()
    {
        $this->user->syncRoles(['Pimpinan']);

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.purchase-order.index'))
            ->assertStatus(200);
    }

    public function test_user_can_see_purchase_orders_as_card()
    {
        $this->user->syncRoles(['Pimpinan']);

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.purchase-order.index'))
            ->assertViewHasAll(['purchase_orders'])
            ->assertSee('card');
    }
}
