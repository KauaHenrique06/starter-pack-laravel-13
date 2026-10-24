<?php 

namespace App\Services\Role;

use App\Http\Resources\Role\RoleCollection;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleService
{
    public function index(array $data): RoleCollection
    {
        $role = Role::with('permissions')->paginate($data['perPage'], ['*'], 'page', $data['page']);
        return new RoleCollection($role);
    }

    public function show(array $data): RoleResource
    {
        $role = Role::with('permissions')->findOrFail($data['id']);
        return new RoleResource($role);
    }

    public function update(array $data): RoleResource
    {
        $role = Role::findOrFail($data['id']);

        DB::transaction(fn () => $role->syncPermissions($data['permissions']));

        return new RoleResource($role->load('permissions'));
    }
}