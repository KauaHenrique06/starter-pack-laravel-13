<?php 

namespace App\Services\Permission;

use App\Http\Resources\Permission\PermissionCollection;
use App\Models\Permission;

class PermissionService
{
    public function index(array $data): PermissionCollection
    {
        $permission = Permission::paginate($data['perPage'], ['*'], 'page', $data['page']);

        return new PermissionCollection($permission);   
    }
}