<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class US06_UpdateRoleAndPermissionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $role;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed('RoleAndPermissionSeeder');

        $this->role = Role::create([
            'name' => 'Testing',
        ]);

        $this->user = User::factory()->create([
            'email' => 'user@nurrahma.test'
        ]);
    }

    public function test_authorized_user_can_access_edit_role_page()
    {
        $this->user->assignRole('Pimpinan');

        $this->actingAs($this->user)
            ->get('/dashboard/role-and-permission/'. $this->role->id . '/edit')
            ->assertStatus(200)
            ->assertViewIs('dashboard.role-and-permission.edit');
    }

public function test_user_can_edit_role_with_valid_input()
{
    $this->user->assignRole('Pimpinan');

    $data = [
        'name' => 'Testing',
        'permissions' => [
            'users.update',
        ],
        '_token' => csrf_token(),
    ];

    $this->actingAs($this->user)
        ->put('/dashboard/role-and-permission/'. $this->role->id, $data)
        ->assertRedirectToRoute('dashboard.role-and-permission.index')
        ->assertSessionHas('success', 'Berhasil mengubah data');
}

    public function test_user_cannot_edit_role_without_name()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            'name' => null,
            'permissions' => [
                'users.update',
            ],
            '_token' => csrf_token()
        ];

        $this->actingAs($this->user)
            ->put('/dashboard/role-and-permission/'. $this->role->id, $data)
            ->assertRedirect()
            ->assertSessionHasErrors('name');
    }

    public function test_user_cannot_edit_role_without_permissions()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            'name' => 'Testing No Permission',
            'permissions' => null,
            '_token' => csrf_token()
        ];

        $this->actingAs($this->user)
            ->put('/dashboard/role-and-permission/'. $this->role->id, $data)
            ->assertRedirect()
            ->assertSessionHasErrors('permissions');
    }

    public function test_unauthorized_user_cannot_access_edit_role_page()
    {
        $this->user->assignRole('Marketing');

        $this->actingAs($this->user)
            ->get('/dashboard/role-and-permission/' . $this->role->id . '/edit')
            ->assertStatus(403);
    }
}
