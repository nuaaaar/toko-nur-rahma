<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\RoleAndPermission\RoleAndPermissionService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use DB;
use Log;
use Throwable;

class UserController extends Controller
{
    protected $userService;
    protected $roleAndPermissionService;

    public function __construct(UserService $userService, RoleAndPermissionService $roleAndPermissionService)
    {
        $this->userService = $userService;
        $this->roleAndPermissionService = $roleAndPermissionService;

        $this->middleware(['permission:users.read'], ['only' => ['index']]);
        $this->middleware(['permission:users.create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:users.update'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:users.delete'], ['only' => ['destroy']]);    }

    public function index(Request $request)
    {
        $request['orderBy'] = $request->orderBy ?? 'name'; // Atur default orderBy
        $request['orderType'] = $request->orderType ?? 'asc'; // Atur default orderType

        $data['roles'] = $this->roleAndPermissionService->all(); // Ambil data hak akses
        $data['users'] = $this->userService->getUsersWithRoleName($request->orderBy, $request->orderType, $request->filters, $request->search, 10);

        return view('dashboard.user.index', $data); // Tampilkan halaman pengguna
    }

    public function create()
    {
        $data['roles'] = $this->roleAndPermissionService->all(); // Ambil data hak akses

        return view('dashboard.user.create', $data); // Tampilkan halaman tambah pengguna
    }

    public function store(CreateUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->userService->createUser($request); // Buat data pengguna

            $user->syncRoles($request->roles); // Sinkronisasi hak akses

            DB::commit();

            return redirect()->route('dashboard.user.index')->with('success', 'Berhasil menambahkan data'); // Redirect ke halaman pengguna
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function edit($id)
    {
        $data['user'] = $this->userService->getUserWithRoleNameById($id); // Ambil data pengguna berdasarkan id
        $data['roles'] = $this->roleAndPermissionService->all(); // Ambil data hak akses

        return view('dashboard.user.edit', $data); // Tampilkan halaman edit pengguna
    }

    public function update(UpdateUserRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $user = $this->userService->updateUser($request, $id); // Buat data pengguna

            $user->syncRoles($request->roles); // Sinkronisasi hak akses

            DB::commit();

            return redirect()->route('dashboard.user.index')->with('success', 'Berhasil mengubah data'); // Redirect ke halaman pengguna
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->delete($id); // Hapus data pengguna

            return redirect()->route('dashboard.user.index')->with('success', 'Berhasil menghapus data'); // Redirect ke halaman pengguna
        } catch (Throwable $e) {
            return redirect()->back()->with('error', $e); // Jika gagal, maka redirect ke halaman login dengan pesan error
        }
    }
}
