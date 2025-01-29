<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Repositories\AuthRepository;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    use ApiResponseTrait;

    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authRepository->register($request->validated());
        return $this->successResponse($user, 'Registration successful');
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authRepository->login($request->validated());
        return $this->successResponse($user, 'Login successful');
    }

    public function logout(Request $request)
    {
        $this->authRepository->logout($request->user());
        return $this->successResponse('', 'Logged out successfully');
    }
}
