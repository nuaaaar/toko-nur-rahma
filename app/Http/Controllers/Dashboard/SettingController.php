<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\User;
use App\Services\User\UserService;
use Auth;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $user = Auth::user();

        return $this->edit($user);
    }

    protected function edit(User $user)
    {
        $data['user'] = $user;

        return view('dashboard.setting.edit', $data);
    }

    public function update(UpdateProfileRequest $request, $id)
    {
        $this->userService->updateUser($request, $id);

        return redirect()->back()->with('success', 'Berhasil mengubah data');
    }
}
