<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Services\RoleAndPermission\RoleAndPermissionService;
use Illuminate\Http\Request;
use DB;
use Log;
use Throwable;

class RoleAndPermissionController extends Controller
{
    protected $roleAndPermissionService;

    public function __construct(RoleAndPermissionService $roleAndPermissionService)
    {
        $this->roleAndPermissionService = $roleAndPermissionService;

        $this->middleware(['permission:roles.read'], ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        $request['orderBy'] = $request->orderBy ?? 'name'; // Atur default orderBy
        $request['orderType'] = $request->orderType ?? 'asc'; // Atur default orderType

        $data['groupedPermissions'] = $this->roleAndPermissionService->getGroupedPermissionsByPrefix(); // Ambil data hak akses yang sudah dikelompokkan berdasarkan prefix
        $data['roles'] = $this->roleAndPermissionService->getRolesWithPermissions($request->orderBy, $request->orderType, $request->search, 10); // Ambil data jenis pengguna dan hak aksesnya dengan pagination 10 data per halaman

        return view('dashboard.role-and-permission.index', $data); // Tampilkan halaman jenis pengguna
    }

    public function create()
    {
        $data['groupedPermissions'] = $this->roleAndPermissionService->getGroupedPermissionsByPrefix(); // Ambil data hak akses yang sudah dikelompokkan berdasarkan prefix

        return view('dashboard.role-and-permission.create', $data); // Tampilkan halaman tambah jenis pengguna
    }

    public function store(CreateRoleRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = $this->roleAndPermissionService->createRole($request); // Buat data jenis pengguna
            $role->syncPermissions($request->permissions); // Sinkronisasi hak akses

            DB::commit();

            return redirect()->route('dashboard.role-and-permission.index')->with('success', 'Berhasil menambahkan data jenis pengguna'); // Redirect ke halaman jenis pengguna
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function edit($id)
    {
        $data['role'] = $this->roleAndPermissionService->getRoleWithPermissionsById($id); // Ambil data jenis pengguna dan hak aksesnya
        $data['groupedPermissions'] = $this->roleAndPermissionService->getGroupedPermissionsByPrefix(); // Ambil data hak akses yang sudah dikelompokkan berdasarkan prefix

        return view('dashboard.role-and-permission.edit', $data); // Tampilkan halaman edit jenis pengguna
    }

    public function update(UpdateRoleRequest $request, int $id)
    {
        DB::beginTransaction();
        try{
            $role = $this->roleAndPermissionService->updateRole($request, $id); // Update data jenis pengguna
            $role->syncPermissions($request->permissions); // Sinkronisasi hak akses

            DB::commit();

            return redirect()->route('dashboard.role-and-permission.index')->with('success', 'Berhasil mengubah data jenis pengguna'); // Redirect ke halaman jenis pengguna
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function destroy(int $id)
    {
        DB::beginTransaction();
        try {
            $this->roleAndPermissionService->deleteRole($id); // Hapus data jenis pengguna

            DB::commit();

            return redirect()->route('dashboard.role-and-permission.index')->with('success', 'Berhasil menghapus data jenis pengguna'); // Redirect ke halaman jenis pengguna
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }
}
