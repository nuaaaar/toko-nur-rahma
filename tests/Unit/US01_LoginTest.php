<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        ]); // Buat user dummy
    }

    public function test_login_page_can_be_rendered()
    {
        $response = $this->get('/login'); // Akses halaman login

        $response->assertStatus(200); // Cek bahwa halaman dapat diakses
        $response->assertViewIs('auth.login'); // Cek bahwa halaman yang ditampilkan adalah auth.login
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $data = [ // Data yang akan dikirim
            'email' => $this->user->email,
            'password' => 'password',
            '_token' => csrf_token()
        ];
        $response = $this->post('/login', $data); // Kirim data ke endpoint /login

        $response->assertRedirectToRoute('dashboard.index'); // Cek bahwa user akan diarahkan ke route dashboard.index
        $this->assertAuthenticatedAs($this->user); // Cek bahwa user telah terotentikasi
    }

    public function test_user_cannot_login_with_incorrect_email()
    {
        $data = [ // Data yang akan dikirim
            'email' => 'wrong-email',
            'password' => 'password',
            '_token' => csrf_token()
        ];
        $this
            ->post('/login', $data) // Kirim data ke endpoint /login
            ->assertRedirect() // Cek bahwa user akan diarahkan ke halaman sebelumnya
            ->assertSessionHasErrors('email'); // Cek bahwa user akan menerima pesan error
        $this->assertGuest(); // Cek bahwa user tidak terotentikasi
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $data = [ // Data yang akan dikirim
            'email' => $this->user->email,
            'password' => 'wrong-password',
            '_token' => csrf_token()
        ];
        $this
            ->post('/login', $data) // Kirim data ke endpoint /login
            ->assertRedirect() // Cek bahwa user akan diarahkan ke halaman sebelumnya
            ->assertSessionHasErrors('password'); // Cek bahwa user akan menerima pesan error
        $this->assertGuest(); // Cek bahwa user tidak terotentikasi
    }

    public function test_user_cannot_login_without_email()
    {
        $data = [ // Data yang akan dikirim
            'email' => '',
            'password' => 'password',
            '_token' => csrf_token()
        ];
        $this
            ->post('/login', $data) // Kirim data ke endpoint /login
            ->assertRedirect() // Cek bahwa user akan diarahkan ke halaman sebelumnya
            ->assertSessionHasErrors('email'); // Cek bahwa user akan menerima pesan error
        $this->assertGuest(); // Cek bahwa user tidak terotentikasi
    }

    public function test_user_cannot_login_without_password()
    {
        $data = [ // Data yang akan dikirim
            'email' => $this->user->email,
            'password' => '',
            '_token' => csrf_token()
        ];
        $this
            ->post('/login', $data) // Kirim data ke endpoint /login
            ->assertRedirect() // Cek bahwa user akan diarahkan ke halaman sebelumnya
            ->assertSessionHasErrors('password'); // Cek bahwa user akan menerima pesan error
        $this->assertGuest(); // Cek bahwa user tidak terotentikasi
    }
}
