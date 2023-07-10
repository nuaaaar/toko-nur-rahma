<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\User;
use App\Traits\DateTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US54_ReadProfitLossTest extends TestCase
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
    }

    public function test_authorized_user_can_read_profit_loss()
    {
        $this->user->syncRoles(['Pimpinan']);

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.profit-loss.index'))
            ->assertStatus(200);
    }

    public function test_user_can_see_total_transaction_by_selected_dates()
    {
        $this->user->syncRoles(['Pimpinan']);

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.profit-loss.index', ['filters' => [ 'date_from' => date('Y-m-d', strtotime('-10 days')), 'date_to' => date('Y-m-d', strtotime('-3 days')), ]]))
            ->assertStatus(200)
            ->assertSee(date('Y-m-d', strtotime('-10 days')))
            ->assertSee(date('Y-m-d', strtotime('-3 days')))
            ->assertSee('Total Penjualan')
            ->assertSee('Total Pengadaan Stok')
            ->assertSee('Total Retur Customer');
    }

    public function test_user_can_see_total_profit_loss_by_selected_dates()
    {
        $this->user->syncRoles(['Pimpinan']);

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.profit-loss.index', ['filters' => [ 'date_from' => date('Y-m-d', strtotime('-10 days')), 'date_to' => date('Y-m-d', strtotime('-3 days')), ]]))
            ->assertStatus(200)
            ->assertSee(date('Y-m-d', strtotime('-10 days')))
            ->assertSee(date('Y-m-d', strtotime('-3 days')))
            ->assertSee('Total Laba-Rugi');
    }


    public function test_user_can_see_history_transaction_loss_by_selected_dates()
    {
        $this->user->syncRoles(['Pimpinan']);

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.profit-loss.index', ['filters' => [ 'date_from' => date('Y-m-d', strtotime('-10 days')), 'date_to' => date('Y-m-d', strtotime('-3 days')), ]]))
            ->assertStatus(200)
            ->assertSee(date('Y-m-d', strtotime('-10 days')))
            ->assertSee(date('Y-m-d', strtotime('-3 days')))
            ->assertSee('Riwayat Penjualan')
            ->assertSee('Riwayat Pengadaan Stok')
            ->assertSee('Riwayat Retur Customer');
    }

    public function test_unauthorized_user_cannot_read_profit_loss()
    {
        $this->user->syncRoles(['Marketing']);

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.profit-loss.index'))
            ->assertStatus(403);
    }
}
