<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class US12_DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_delete_user()
    {
        $this->seed('RoleAndPermissionSeeder');

        $user = User::factory()->create();
        $user->assignRole('Pimpinan');

        $testUser = User::factory()->create(['name' => 'Testing User']);

        $data = [
            '_method' => 'DELETE',
            '_token' => csrf_token()
        ];
        $response = $this->actingAs($user)->post(route('dashboard.user.destroy', $testUser->id), $data);
        $response->assertRedirectToRoute('dashboard.user.index');
    }

    public function test_unauthorized_user_cannot_delete_user()
    {
        $this->seed('RoleAndPermissionSeeder');

        $user = User::factory()->create();

        $testUser = User::factory()->create(['name' => 'Testing User']);

        $data = [
            '_method' => 'DELETE',
            '_token' => csrf_token()
        ];
        $response = $this->actingAs($user)->post(route('dashboard.user.destroy', $testUser->id), $data);
        $response->assertStatus(403);
    }
}
