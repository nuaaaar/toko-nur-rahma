<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US24_UpdateProductTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $category;

    protected $existingProduct;

    protected $otherExistingProduct;

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

        $this->otherExistingProduct = Product::create([
            'name' => 'Kalkulator 2',
            'category_id' => $this->category->id,
            'product_code' => '00002',
            'barcode' => null,
            'unit' => 'PCS',
            'capital_price' => '80000',
            'selling_price' => '150000',
        ]);
    }

    public function test_authorized_user_can_access_edit_product_page()
    {
        $this->user->assignRole('Pimpinan');

        $this->actingAs($this->user)
            ->get('/dashboard/product/'. $this->existingProduct->id .'/edit')
            ->assertStatus(200)
            ->assertViewIs('dashboard.product.edit');
    }

    public function test_user_can_edit_product_with_valid_input()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            'name' => 'Pensil',
            'category_id' => $this->category->id,
            'product_code' => '00001',
            'barcode' => null,
            'unit' => 'PCS',
            'capital_price' => '85000',
            'selling_price' => '150000',
        ];

        $this->actingAs($this->user)
            ->put('/dashboard/product/' . $this->existingProduct->id, $data)
            ->assertRedirectToRoute('dashboard.product.index')
            ->assertSessionHas('success', 'Berhasil mengubah data');
    }

    public function test_user_cannot_edit_product_without_required_inputs()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            'name' => null,
            'category_id' => null,
            'product_code' => null,
            'barcode' => null,
            'unit' => null,
            'capital_price' => null,
            'selling_price' => null,
            '_token' => csrf_token()
        ];

        $this->actingAs($this->user)
            ->put('/dashboard/product/' . $this->existingProduct->id, $data)
            ->assertRedirect()
            ->assertSessionHasErrors('name')
            ->assertSessionHasErrors('category_id')
            ->assertSessionHasErrors('product_code')
            ->assertSessionHasErrors('unit')
            ->assertSessionHasErrors('capital_price')
            ->assertSessionHasErrors('selling_price');
    }

    public function test_user_cannot_edit_product_with_duplicate_product_code()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            'name' => 'Kalkulator 2',
            'category_id' => $this->category->id,
            'product_code' => '00002',
            'barcode' => null,
            'unit' => 'PCS',
            'capital_price' => '85000',
            'selling_price' => '150000',
        ];

        $this->actingAs($this->user)
            ->put('/dashboard/product/' . $this->existingProduct->id, $data)
            ->assertRedirect()
            ->assertSessionHasErrors('product_code');
    }

    public function test_unauthorized_user_cannot_access_edit_product_page()
    {
        $this->user->assignRole('Marketing');

        $this->actingAs($this->user)
            ->get('/dashboard/product/create')
            ->assertStatus(403);
    }
}
