<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Repositories\UserRepository;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\UpdatePreferenceRequest;

class UserController extends Controller
{
    use ApiResponseTrait;

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function profile(Request $request)
    {
        return $this->successResponse(auth()->user());
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $this->userRepository->updateProfile($request->user(), $request->validated());
        return $this->successResponse($user, 'Profile updated successfully');
    }

    public function getPreferences(Request $request)
    {
        $preferences = $this->userRepository->getPreferences(auth()->user());
        return $this->successResponse($preferences, 'Preferences retrieved successfully');
    }

    public function updatePreferences(UpdatePreferenceRequest $request)
    {
        $preferences = $this->userRepository->updatePreferences($request->user(), $request->validated());
        return $this->successResponse($preferences, 'Preferences updated successfully');
    }
}
