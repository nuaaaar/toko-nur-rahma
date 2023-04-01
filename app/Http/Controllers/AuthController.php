<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\User\UserServiceImplement;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserServiceImplement $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('auth.login'); // Tampilkan halaman login
    }

    public function login(LoginRequest $request)
    {
        try{
            $this->userService->authenticate($request); // Lakukan autentikasi

            return redirect()->route('dashboard.index'); // Redirect ke halaman dashboard
        } catch (ValidationException $e) {
            return redirect()->route('login')->withErrors($e->errors()); // Jika gagal, maka redirect ke halaman login dengan pesan error
        }
    }
}
