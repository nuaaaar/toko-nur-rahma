<?php

namespace App\Services\User;

use App\Http\Requests\LoginRequest;
use LaravelEasyRepository\BaseService;

interface UserService extends BaseService{

    // Write something awesome :)

    public function authenticate(LoginRequest $request);
}
