<?php

namespace App\Http\Controllers\Role;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\IndexRoleRequest;
use App\Http\Requests\Role\ShowRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Services\Role\RoleService;
use App\Support\ReturnApi;

class RoleController extends Controller
{
    public function __construct(protected RoleService $roleService) {}

    public function index(IndexRoleRequest $request) 
    {
        try {

            $data = $this->roleService->index($request->validated());
            return ReturnApi::success(
                $data,
                'Role indexed successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to index user: ' . $e->getMessage());
        }
    }

    public function show(ShowRoleRequest $request) 
    {
        try {

            $data = $this->roleService->show($request->validated());
            return ReturnApi::success(
                $data,
                'Role showed successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to show user: ' . $e->getMessage());
        }
    }

    public function update(UpdateRoleRequest $request) 
    {
        try {

            $this->roleService->update($request->validated());
            return ReturnApi::success(
                null,
                'Role updated successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to update user: ' . $e->getMessage());
        }
    }
}
