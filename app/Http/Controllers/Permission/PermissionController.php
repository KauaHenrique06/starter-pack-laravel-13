<?php

namespace App\Http\Controllers\Permission;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\IndexPermissionRequest;
use App\Services\Permission\PermissionService;
use App\Support\ReturnApi;

class PermissionController extends Controller
{
    public function __construct(protected PermissionService $permissionService) {}

    public function index(IndexPermissionRequest $request) 
    {
        try {

            $data = $this->permissionService->index($request->validated());
            return ReturnApi::success(
                $data,
                'Permission indexed successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to index permission: ' . $e->getMessage());
        }
    }
}
