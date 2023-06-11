<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class US07_DeleteRoleAndPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_delete_role_and_permission()
    {
        $this->seed('RoleAndPermissionSeeder');

        $user = User::factory()->create();
        $user->assignRole('Pimpinan');

        $role = Role::create(['name' => 'Testing Role']);

        $data = [
            '_method' => 'DELETE',
            '_token' => csrf_token()
        ];
        $response = $this->actingAs($user)->post(route('dashboard.role-and-permission.destroy', $role->id), $data);
        $response->assertRedirectToRoute('dashboard.role-and-permission.index');
    }

    public function test_unauthorized_user_cannot_delete_role_and_permission()
    {
        $this->seed('RoleAndPermissionSeeder');

        $user = User::factory()->create();

        $role = Role::create(['name' => 'Testing Role']);

        $data = [
            '_method' => 'DELETE',
            '_token' => csrf_token()
        ];
        $response = $this->actingAs($user)->post(route('dashboard.role-and-permission.destroy', $role->id), $data);
        $response->assertStatus(403);
    }
}
