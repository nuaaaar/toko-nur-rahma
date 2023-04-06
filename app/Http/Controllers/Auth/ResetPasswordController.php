<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\User\UserServiceImplement;
use Exception;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    protected $userService;

    public function __construct(UserServiceImplement $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('auth.reset-password');
    }

    public function reset(ResetPasswordRequest $request)
    {
        try {
            $this->userService->resetPassword($request);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diubah.');
    }
}
