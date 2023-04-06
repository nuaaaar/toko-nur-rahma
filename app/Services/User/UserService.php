<?php

namespace App\Services\User;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;
use LaravelEasyRepository\BaseService;

interface UserService extends BaseService{

    // Write something awesome :)

    public function authenticate(LoginRequest $request);

    public function logout();

    public function sentResetLinkEmail(Request $request);

    public function resetPassword(ResetPasswordRequest $request);
}
