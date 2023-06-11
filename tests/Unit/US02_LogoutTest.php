<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        ]);
    }

    public function test_user_redirected_to_login_page_after_logout()
    {
        $this->actingAs($this->user);

        $this->get('/logout')
            ->assertRedirectToRoute('login');

        $this->assertGuest();
    }
}
