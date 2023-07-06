<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US04_CreateRoleAndPermissionTest extends TestCase
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

    public function test_authorized_user_can_access_create_role_page()
    {
        $this->user->assignRole('Pimpinan');

        $this->actingAs($this->user)
            ->get('/dashboard/role-and-permission/create')
            ->assertStatus(200)
            ->assertViewIs('dashboard.role-and-permission.create');
    }

    public function test_user_can_create_role_with_valid_input()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            'name' => 'Testing',
            'permissions' => [
                'users.create',
            ],
            '_token' => csrf_token()
        ];

        $this->actingAs($this->user)
            ->post('/dashboard/role-and-permission', $data)
            ->assertRedirectToRoute('dashboard.role-and-permission.index')
            ->assertSessionHas('success', 'Berhasil menambah data');
    }

    public function test_user_cannot_create_role_without_name()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            'name' => null,
            'permissions' => [
                'users.create',
            ],
            '_token' => csrf_token()
        ];

        $this->actingAs($this->user)
            ->post('/dashboard/role-and-permission', $data)
            ->assertRedirect()
            ->assertSessionHasErrors('name');
    }

    public function test_user_cannot_create_role_without_permissions()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            'name' => 'Testing No Permission',
            'permissions' => null,
            '_token' => csrf_token()
        ];

        $this->actingAs($this->user)
            ->post('/dashboard/role-and-permission', $data)
            ->assertRedirect()
            ->assertSessionHasErrors('permissions');
    }

    public function test_unauthorized_user_cannot_access_create_role_page()
    {
        $this->user->assignRole('Marketing');

        $this->actingAs($this->user)
            ->get('/dashboard/role-and-permission/create')
            ->assertStatus(403);
    }
}
