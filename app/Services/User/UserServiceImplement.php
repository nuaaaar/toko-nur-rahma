<?php

namespace App\Services\User;

use App\Http\Requests\LoginRequest;
use LaravelEasyRepository\Service;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserServiceImplement extends Service implements UserService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(UserRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function authenticate(LoginRequest $request)
    {
        $user = $this->mainRepository->findByEmail($request->email);
        if($user == null) {
            throw ValidationException::withMessages([
                'email' => 'Email tidak terdaftar.'
            ]);
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return true;
        }

        throw ValidationException::withMessages([
            'password' => 'Kata sandi salah.'
        ]);
    }
}
