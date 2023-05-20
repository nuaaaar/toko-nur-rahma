<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use App\Services\User\UserServiceImplement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('auth.forgot-password'); // Tampilkan halaman lupa password
    }

    public function sentResetLinkEmail(Request $request)
    {
        try {
            $status = $this->userService->sentResetLinkEmail($request); // Kirim email reset password

            return redirect()->route('login')->with('success', __($status)); // Redirect ke halaman login dengan pesan sukses
        } catch (ValidationException | Exception $e) {
            if (gettype($e) == Exception::class) {
                return redirect()->back()->with('error', $e->getMessage());
            }
            return redirect()->back()->withErrors($e->errors()); // Jika gagal, maka redirect ke halaman lupa password dengan pesan error
        }

    }
}
