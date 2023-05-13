<?php

namespace App\Services\RoleAndPermission;

use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use LaravelEasyRepository\BaseService;

interface RoleAndPermissionService extends BaseService{

    // Write something awesome :)

    public function getRolesWithPermissions(string $orderBy, string $orderType, ?string $search, int $pageLength = 10);

    public function getRoleWithPermissionsById(int $id);

    public function getGroupedPermissionsByPrefix();

    public function createRole(CreateRoleRequest $request);

    public function updateRole(UpdateRoleRequest $request, int $id);

    public function deleteRole(int $id);
}
