<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class US07_DeleteRoleAndPermissionTest extends TestCase
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

    public function test_authorized_user_can_delete_role_and_permission()
    {
        $this->user->assignRole('Pimpinan');

        $data = [
            '_token' => csrf_token()
        ];
        $this->
            actingAs($this->user)
            ->delete(route('dashboard.role-and-permission.destroy', $this->role->id), $data)
            ->assertRedirectToRoute('dashboard.role-and-permission.index')
            ->assertSessionHas('success', 'Berhasil menghapus data');
    }

    public function test_unauthorized_user_cannot_delete_role_and_permission()
    {
        $this->user->assignRole('Marketing');
        $data = [
            '_token' => csrf_token()
        ];
        $this->actingAs($this->user)
            ->delete(route('dashboard.role-and-permission.destroy', $this->role->id), $data)
            ->assertStatus(403);
    }
}
