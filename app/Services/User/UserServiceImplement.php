<?php

namespace App\Services\User;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use LaravelEasyRepository\Service;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
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
        if (Auth::attempt($credentials, isset($request->remember))) {
            return true;
        }

        throw ValidationException::withMessages([
            'password' => 'Kata sandi salah.'
        ]);
    }

    public function logout()
    {
        Auth::logout();
    }

    public function sentResetLinkEmail(Request $request)
    {
        $credentials = $request->only(['email']);
        $status = Password::sendResetLink($credentials);

        if ($status === Password::INVALID_USER) {
            throw ValidationException::withMessages([
                'email' => 'Email tidak terdaftar.'
            ]);
        }

        if ($status !== Password::RESET_LINK_SENT && $status !== Password::INVALID_USER) {
            throw new Exception('Gagal mengirim email reset password.');
        }

        return $status;
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ]);

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function getUsersWithRoleName(string $orderBy, string $orderType, ?array $filters, ?string $search, int $limit)
    {
        return $this->mainRepository->joinRoleName()->exceptSuperadmin()->filter($filters)->search($search)->orderData($orderBy, $orderType)->paginate($limit);
    }

    public function getUserWithRoleNameById(int $id)
    {
        return $this->mainRepository->joinRoleName()->findOrFail($id);
    }

    public function createUser(CreateUserRequest $request)
    {
        return $this->mainRepository->create($request->except('roles'));
    }

    public function updateUser(UpdateUserRequest | UpdateProfileRequest $request, int $id)
    {
        $user = $this->mainRepository->findOrFail($id);

        $request['password'] = $request->password ? bcrypt($request->password) : $user->password;

        $user->update($request->except('roles'));

        return $user;
    }
}
