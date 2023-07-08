<?php

namespace Tests\Unit;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US48_PrintSaleInvoiceTest extends TestCase
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


    public function test_authorized_user_can_access_sale_invoice_page()
    {
        $this->user->assignRole('Pimpinan');

        $this->actingAs($this->user)
            ->get('/dashboard/sale/' . $this->existingSale->id . '/invoice')
            ->assertStatus(200)
            ->assertViewIs('dashboard.sale.invoice');
    }
}
