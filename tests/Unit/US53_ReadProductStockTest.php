<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Traits\DateTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US53_ReadProductStockTest extends TestCase
{
    use RefreshDatabase;

    use DateTrait;

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

    public function test_authorized_user_can_read_product_stock()
    {
        $this->user->syncRoles(['Pimpinan']);

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.product-stock.index'))
            ->assertStatus(200);
    }

    public function test_user_can_read_product_stock_by_default_dates()
    {
        $this->user->syncRoles(['Pimpinan']);

        $dates = $this->getDates(date('Y-m-d', strtotime('-7 days')), date('Y-m-d'));

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.product-stock.index'))
            ->assertStatus(200)
            ->assertSee(collect($dates)->map(function ($date) {
                return date('m/d', strtotime($date));
            })->toArray());

    }

    public function test_user_can_read_product_stock_by_selected_dates()
    {
        $this->user->syncRoles(['Pimpinan']);

        $dates = $this->getDates(date('Y-m-d', strtotime('-10 days')), date('Y-m-d', strtotime('-3 days')));

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.product-stock.index', [
                'date_from' => date('Y-m-d', strtotime('-10 days')),
                'date_to' => date('Y-m-d', strtotime('-3 days')),
            ]))
            ->assertStatus(200)
            ->assertSee(collect($dates)->map(function ($date) {
                return date('m/d', strtotime($date));
            })->toArray());
    }

    public function test_unauthorized_user_cannot_read_product_stock()
    {
        $this->user->syncRoles(['Marketing']);

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.product-stock.index'))
            ->assertStatus(403);
    }
}
