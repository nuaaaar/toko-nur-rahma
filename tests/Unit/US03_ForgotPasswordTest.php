<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class US03_ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'yanuar.fabien.yf@gmail.com'
        ]);
    }

    public function test_user_can_request_reset_password_link_with_correct_email()
    {
        $data = [
            'email' => $this->user->email
        ];

        $this->post('/forgot-password', $data)
        ->assertRedirectToRoute('login')
        ->assertSessionHas('success', __('passwords.sent'));

    }

    public function test_user_cannot_request_reset_password_link_without_email()
    {
        $data = [ // Data yang akan dikirim
            'email' => ''
        ];
        $this->post('/forgot-password', $data) // Kirim data ke endpoint /forgot-password
            ->assertRedirect() // Cek bahwa user akan diarahkan ke halaman sebelumnya
            ->assertSessionHasErrors('email'); // Cek bahwa user akan menerima pesan error
    }

    public function test_user_cannot_request_reset_password_link_with_incorrect_email()
    {
        $data = [ // Data yang akan dikirim
            'email' => 'wrong-email'
        ];
        $this->post('/forgot-password', $data) // Kirim data ke endpoint /forgot-password
            ->assertRedirect() // Cek bahwa user akan diarahkan ke halaman sebelumnya
            ->assertSessionHasErrors('email'); // Cek bahwa user akan menerima pesan error
    }
}
