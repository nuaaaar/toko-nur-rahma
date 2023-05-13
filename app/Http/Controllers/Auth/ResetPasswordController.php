<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('auth.reset-password'); // Tampilkan halaman atur ulang kata sandi
    }

    public function reset(ResetPasswordRequest $request)
    {
        try {
            $this->userService->resetPassword($request); // Lakukan atur ulang kata sandi
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diubah.');
    }
}
