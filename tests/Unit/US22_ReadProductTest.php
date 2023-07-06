<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US22_ReadProductTest extends TestCase
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

    public function test_authorized_user_can_read_product()
    {
        $this->user->assignRole('Pimpinan');

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.product.index'))
            ->assertStatus(200);
    }

    public function test_user_can_see_product_list_as_table()
    {
        $this->user->assignRole('Pimpinan');

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.product.index'))
            ->assertSee('Kode')
            ->assertSee('Nama Barang')
            ->assertSee('Kategori')
            ->assertSee('Satuan')
            ->assertSee('Harga Modal')
            ->assertSee('Harga Jual')
            ->assertViewHasAll(['products']);
    }

    public function test_user_can_search_product_by_name()
    {
        $this->user->assignRole('Pimpinan');

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.product.index', ['search' => 'Pensil']))
            ->assertSee('Pensil');
    }

    public function test_unauthorized_user_cannot_read_product()
    {
        $this->user->assignRole('Marketing');

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.product.index'))
            ->assertStatus(403);
    }
}
