<?php

namespace App\Http\Controllers\User;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\IndexUserRequest;
use App\Http\Requests\User\ShowUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\User\UserService;
use App\Support\ReturnApi;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function store(StoreUserRequest $request) 
    {
        try {

            $data = $this->userService->store($request->validated());
            return ReturnApi::success(
                $data,
                'User created successfully!',
                201
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to create user: ' . $e->getMessage());
        }
    }

    public function index(IndexUserRequest $request) 
    {
        try {

            $data = $this->userService->index($request->validated());
            return ReturnApi::success(
                $data,
                'Users indexed successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to index users: ' . $e->getMessage());
        }
    }

    public function show(ShowUserRequest $request) 
    {
        try {

            $data = $this->userService->show($request->validated());
            return ReturnApi::success(
                $data,
                'User showed successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to show user: ' . $e->getMessage());
        }
    }

    public function update(UpdateUserRequest $request) 
    {
        try {

            $data = $this->userService->update($request->validated());
            return ReturnApi::success(
                $data,
                'User updated successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to update user: ' . $e->getMessage());
        }
    }

    public function delete(DeleteUserRequest $request) 
    {
        try {

            $this->userService->delete($request->validated());
            return ReturnApi::success(
                null,
                'User deleted successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to delete user: ' . $e->getMessage());
        }
    }
}
