<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Activate2FaRequest;
use App\Http\Requests\Auth\Login2faRequest;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Services\Auth\AuthService;
use App\Support\ReturnApi;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function register(RegisterUserRequest $request) 
    {
        try {

            $data = $this->authService->register($request->validated());
            return ReturnApi::success(
                $data,
                'User registered successfully!',
                201
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to register: ' . $e->getMessage());
        }
    }

    public function login(LoginUserRequest $request) 
    {
        try {

            $data = $this->authService->login($request->validated());
            return ReturnApi::success(
                $data,
                'User logged successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to login: ' . $e->getMessage());
        }
    }

    public function login2fa(Login2faRequest $request) 
    {
        try {

            $data = $this->authService->login2fa($request->validated());
            return ReturnApi::success(
                $data,
                'User logged successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to login: ' . $e->getMessage());
        }
    }

    public function toggle2fa(Activate2FaRequest $request)
    {
        try {

            $data = $this->authService->toggle2fa($request->validated());
            return ReturnApi::success(
                $data,
                'Two auth factor active successfully!',
                200
            ); 
        } catch(\Exception $e) {
            throw new ApiException('Error to active two auth factor: ' . $e->getMessage());
        }
    }
}
