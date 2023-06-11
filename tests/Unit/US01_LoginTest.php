<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US01_LoginTest extends TestCase
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

    public function test_user_can_access_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $data = [
            'email' => $this->user->email,
            'password' => 'password',
            '_token' => csrf_token()
        ];
        $response = $this->post('/login', $data);

        $response->assertRedirectToRoute('dashboard.index');
        $this->assertAuthenticatedAs($this->user);
    }

    public function test_user_cannot_login_with_incorrect_email()
    {
        $data = [
            'email' => 'wrong-email',
            'password' => 'password',
            '_token' => csrf_token()
        ];
        $this
            ->post('/login', $data)
            ->assertRedirect()
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $data = [
            'email' => $this->user->email,
            'password' => 'wrong-password',
            '_token' => csrf_token()
        ];
        $this
            ->post('/login', $data)
            ->assertRedirect()
            ->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_user_cannot_login_without_email()
    {
        $data = [
            'email' => '',
            'password' => 'password',
            '_token' => csrf_token()
        ];
        $this
            ->post('/login', $data)
            ->assertRedirect()
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_cannot_login_without_password()
    {
        $data = [
            'email' => $this->user->email,
            'password' => '',
            '_token' => csrf_token()
        ];
        $this
            ->post('/login', $data)
            ->assertRedirect()
            ->assertSessionHasErrors('password');
        $this->assertGuest();
    }
}
