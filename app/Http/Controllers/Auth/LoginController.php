<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Log;
use Throwable;

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
        }  catch (Throwable $e) {
            if ($e instanceof ValidationException) return redirect()->back()->withErrors($e->errors())->withInput();

            Log::error($e);

            return abort(500);
        }
    }

    public function logout(Request $request)
    {
        $this->userService->logout($request);

        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
}
