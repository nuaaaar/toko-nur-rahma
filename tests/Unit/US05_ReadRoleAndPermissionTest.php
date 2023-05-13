<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class US05_ReadRoleAndPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_read_role_and_permission()
    {
        $this->seed('RoleAndPermissionSeeder'); // Buat role dan permission sebelum menjalankan test

        $user = User::factory()->create(); // Buat user
        $user->assignRole('Pimpinan'); // Berikan role pimpinan ke user

        $this
            ->actingAs($user) // Login sebagai user dengan role pimpinan
            ->get(route('dashboard.role-and-permission.index')) // Akses halaman role and permission
            ->assertStatus(200); // Cek kode status 200 atau OK
    }

    public function test_unauthorized_user_cannot_read_role_and_permission()
    {
        $this->seed('RoleAndPermissionSeeder'); // Buat role dan permission sebelum menjalankan test

        $user = User::factory()->create(); // Buat user tanpa diberikan role

        $this
            ->actingAs($user) // Login sebagai user dengan role admin pembukuan
            ->get(route('dashboard.role-and-permission.index')) // Akses halaman role and permission
            ->assertStatus(403); // Cek kode status 403 atau Forbidden
    }

    public function test_user_can_search_role_by_name()
    {
        $this->seed('RoleAndPermissionSeeder'); // Buat role dan permission sebelum menjalankan test

        $user = User::factory()->create(); // Buat user
        $user->assignRole('Pimpinan'); // Berikan role pimpinan ke user

        $this
            ->actingAs($user)
            ->get(route('dashboard.role-and-permission.index', ['search' => 'Pimpinan']))
            ->assertSee('Pimpinan');
    }
}
