<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US25_DeleteProductTest extends TestCase
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


    public function test_authorized_user_can_delete_user()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            '_method' => 'DELETE',
            '_token' => csrf_token()
        ];
        $response = $this->actingAs($this->user)->post(route('dashboard.product.destroy', $this->existingProduct->id), $data);
        $response->assertRedirectToRoute('dashboard.product.index');
    }

    public function test_unauthorized_user_cannot_delete_user()
    {
        $this->user->assignRole('Marketing');

        $data = [
            '_method' => 'DELETE',
            '_token' => csrf_token()
        ];
        $response = $this->actingAs($this->user)->post(route('dashboard.product.destroy', $this->existingProduct->id), $data);
        $response->assertStatus(403);
    }
}
