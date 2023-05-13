<?php

namespace App\Services\RoleAndPermission;

use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Repositories\Role\RoleRepository;
use LaravelEasyRepository\Service;

class RoleAndPermissionServiceImplement extends Service implements RoleAndPermissionService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(RoleRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function getRolesWithPermissions(string $orderBy, string $orderType, ?string $search, int $pageLength = 10)
    {
        return $this->mainRepository
                        ->exceptSuperadmin()
                        ->withRelations(['permissions', 'users'])
                        ->orderData($orderBy, $orderType)
                        ->searchByName($search)
                        ->paginate($pageLength);
    }

    public function getRoleWithPermissionsById(int $id)
    {
        return $this->mainRepository->withRelations(['permissions'])->findOrFail($id);
    }

    public function createRole(CreateRoleRequest $request)
    {
        return $this->mainRepository->create(['name' => $request->name]);
    }

    public function updateRole(UpdateRoleRequest $request, int $id)
    {
        $role = $this->mainRepository->findOrFail($id);

        $role->update(['name' => $request->name]);

        return $role;
    }

    public function deleteRole(int $id)
    {
        $role = $this->mainRepository->findOrFail($id);

        $role->delete();

        return $role;
    }

    public function getGroupedPermissionsByPrefix()
    {
        return [
            'roles' => [
                'read',
                'create',
                'update',
                'delete',
            ],
            'users' => [
                'read',
                'create',
                'update',
                'delete',
            ],
        ];
    }
}
