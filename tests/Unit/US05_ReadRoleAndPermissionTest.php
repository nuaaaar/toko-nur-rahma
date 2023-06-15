<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US05_ReadRoleAndPermissionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed('RoleAndPermissionSeeder');

        $this->user = User::factory()->create([
            'email' => 'user@nurrahma.test'
        ]);
    }

    public function test_authorized_user_can_read_role_and_permission()
    {
        $this->user->assignRole('Pimpinan');

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.role-and-permission.index'))
            ->assertStatus(200);
    }

    public function test_unauthorized_user_cannot_read_role_and_permission()
    {
        $this->user->assignRole('Marketing');

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.role-and-permission.index'))
            ->assertStatus(403);
    }

    public function test_user_can_see_role_and_permission_list_as_table()
    {
        $this->user->assignRole('Pimpinan');

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.role-and-permission.index'))
            ->assertSee('Jenis Pengguna')
            ->assertSee('Hak Akses')
            ->assertViewHasAll(['roles']);
    }

    public function test_user_can_search_role_by_name()
    {
        $this->user->assignRole('Pimpinan');

        $this
            ->actingAs($this->user)
            ->get(route('dashboard.role-and-permission.index', ['search' => 'Pimpinan']))
            ->assertSee('Pimpinan');
    }
}
