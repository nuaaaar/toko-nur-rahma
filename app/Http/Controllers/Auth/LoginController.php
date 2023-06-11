<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        try{
            $this->userService->authenticate($request);

            return redirect()->route('dashboard.index');
        } catch (ValidationException $e) {
            return redirect()->route('login')->withErrors($e->errors());
        }
    }

    public function logout(Request $request)
    {
        $this->userService->logout($request);

        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
}
