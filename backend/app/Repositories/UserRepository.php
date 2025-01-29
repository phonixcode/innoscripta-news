<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function updateProfile(User $user, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function getPreferences($user)
    {
        return $user->preference ?? [];
    }

    public function updatePreferences($user, array $data)
    {
        $preference = $user->preference ?: new UserPreference(['user_id' => $user->id]);

        $preference->fill([
            'sources' => $data['sources'] ?? [],
            'categories' => $data['categories'] ?? [],
            'authors' => $data['authors'] ?? [],
        ]);

        $preference->save();
        return $preference;
    }

    public function getPreferencesForUser($userId)
    {
        return UserPreference::where('user_id', $userId)->first();
    }
}