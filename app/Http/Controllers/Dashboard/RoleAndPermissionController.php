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
        $this->middleware(['permission:roles.create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:roles.update'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:roles.delete'], ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $request['orderBy'] = $request->orderBy ?? 'name';
        $request['orderType'] = $request->orderType ?? 'asc';

        $data['groupedPermissions'] = $this->roleAndPermissionService->getGroupedPermissionsByPrefix();
        $data['roles'] = $this->roleAndPermissionService->getRolesWithPermissions($request->orderBy, $request->orderType, $request->search, 10);

        return view('dashboard.role-and-permission.index', $data);
    }

    public function create()
    {
        $data['groupedPermissions'] = $this->roleAndPermissionService->getGroupedPermissionsByPrefix();

        return view('dashboard.role-and-permission.create', $data);
    }

    public function store(CreateRoleRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = $this->roleAndPermissionService->createRole($request);
            $role->syncPermissions($request->permissions);

            DB::commit();

            return redirect()->route('dashboard.role-and-permission.index')->with('success', 'Berhasil menambah data');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function edit($id)
    {
        $data['role'] = $this->roleAndPermissionService->getRoleWithPermissionsById($id);
        $data['groupedPermissions'] = $this->roleAndPermissionService->getGroupedPermissionsByPrefix();

        return view('dashboard.role-and-permission.edit', $data);
    }

    public function update(UpdateRoleRequest $request, int $id)
    {
        DB::beginTransaction();
        try{
            $role = $this->roleAndPermissionService->updateRole($request, $id);
            $role->syncPermissions($request->permissions);

            DB::commit();

            return redirect()->route('dashboard.role-and-permission.index')->with('success', 'Berhasil mengubah data');
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
            $this->roleAndPermissionService->deleteRole($id);

            DB::commit();

            return redirect()->route('dashboard.role-and-permission.index')->with('success', 'Berhasil menghapus data');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }
}
