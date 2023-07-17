<?php

namespace Tests\Unit;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US42_UpdateStatusPurchaseOrderToCancelTest extends TestCase
{
    use RefreshDatabase;

    protected $customer;

    protected $user;

    protected $category;

    protected $bank;

    protected $existingProduct;

    protected $customerService;

    protected $purchaseOrderService;

    protected $purchaseOrderItemService;

    protected $productStockService;

    protected $existingPurchaseOrder;

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

        $this->seed('PurchaseOrderSeeder');

        $this->existingPurchaseOrder = PurchaseOrder::first();
    }

    public function test_authorized_user_can_cancel_purchase_order()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            "_token" => csrf_token(),
            "user_id" => $this->user->id,
            "status" => "dibatalkan",
        ];

        $this->actingAs($this->user)
            ->put('/dashboard/purchase-order/' . $this->existingPurchaseOrder->id . '/change-status', $data)
            ->assertRedirectToRoute('dashboard.purchase-order.index')
            ->assertSessionHas('success', 'Status pemesanan berhasil diubah');
    }

    public function test_unauthorized_user_cannot_cancel_purchase_order()
    {
        $this->user->syncRoles(['Marketing']);

        $data = [
            "_token" => csrf_token(),
            "user_id" => $this->user->id,
            "status" => "dibatalkan",
        ];

        $this->actingAs($this->user)
            ->put('/dashboard/purchase-order/' . $this->existingPurchaseOrder->id . '/change-status', $data)
            ->assertStatus(403);
    }
}
