<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US45_ReadSaleTest extends TestCase
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

    public function test_authorized_user_can_read_sale()
    {
        $this->user->assignRole('Pimpinan');

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.sale.index'))
            ->assertStatus(200)
            ->assertViewHasAll(['sales'])
            ->assertSee('card');
    }

    public function test_unauthorized_user_cannot_read_sale()
    {
        $this->user->assignRole('Marketing');

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.sale.index'))
            ->assertStatus(403);
    }
}
