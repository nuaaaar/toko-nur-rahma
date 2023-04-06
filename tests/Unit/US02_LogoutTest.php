<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class US02_LogoutTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'user@nurrahma.test'
        ]); // Buat user dummy
    }

    public function test_user_can_logout()
    {
        $this->actingAs($this->user); // Login sebagai user

        $this->get('/logout') // Akses route logout
            ->assertRedirectToRoute('login'); // Cek bahwa user akan diarahkan ke route login

        $this->assertGuest(); // Cek bahwa user tidak terotentikasi
    }
}
