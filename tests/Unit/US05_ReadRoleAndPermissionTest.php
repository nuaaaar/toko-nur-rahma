<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US05_ReadRoleAndPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_read_role_and_permission()
    {
        $this->seed('RoleAndPermissionSeeder');

        $user = User::factory()->create();
        $user->assignRole('Pimpinan');

        $this
            ->actingAs($user)
            ->get(route('dashboard.role-and-permission.index'))
            ->assertStatus(200);
    }

    public function test_unauthorized_user_cannot_read_role_and_permission()
    {
        $this->seed('RoleAndPermissionSeeder');

        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('dashboard.role-and-permission.index'))
            ->assertStatus(403);
    }

    public function test_user_can_search_role_by_name()
    {
        $this->seed('RoleAndPermissionSeeder');

        $user = User::factory()->create();
        $user->assignRole('Pimpinan');

        $this
            ->actingAs($user)
            ->get(route('dashboard.role-and-permission.index', ['search' => 'Pimpinan']))
            ->assertSee('Pimpinan');
    }
}
