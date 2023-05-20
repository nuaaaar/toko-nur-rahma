<?php

namespace App\Services\User;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Http\Request;
use LaravelEasyRepository\BaseService;

interface UserService extends BaseService{

    // Write something awesome :)

    public function authenticate(LoginRequest $request);

    public function logout();

    public function sentResetLinkEmail(Request $request);

    public function resetPassword(ResetPasswordRequest $request);

    public function getUsersWithRoleName(string $orderBy, string $orderType, ?array $filters, ?string $search, int $limit);

    public function getUserWithRoleNameById(int $id);

    public function createUser(CreateUserRequest $data);

    public function updateUser(UpdateUserRequest $data, int $id);
}
