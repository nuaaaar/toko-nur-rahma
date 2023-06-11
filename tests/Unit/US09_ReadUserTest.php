<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US09_ReadUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_read_user()
    {
        $this->seed('RoleAndPermissionSeeder');

        $user = User::factory()->create();
        $user->assignRole('Pimpinan');

        $this
            ->actingAs($user)
            ->get(route('dashboard.user.index'))
            ->assertStatus(200);
    }

    public function test_unauthorized_user_cannot_read_user()
    {
        $this->seed('RoleAndPermissionSeeder');

        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('dashboard.user.index'))
            ->assertStatus(403);
    }

    public function test_user_can_search_user_by_name()
    {
        $this->seed('RoleAndPermissionSeeder');

        $user = User::factory()->create();
        $user->assignRole('Pimpinan');

        $this
            ->actingAs($user)
            ->get(route('dashboard.user.index', ['search' => $user->name]))
            ->assertSee($user->name);
    }
}
