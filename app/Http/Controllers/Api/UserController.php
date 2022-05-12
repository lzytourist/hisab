<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponse;

    public function register(UserRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);

            $user = User::query()->create($data);
            $token = $user->createToken('login_token')->plainTextToken;

            Auth::loginUsingId($user->getOriginal('id'));

            return $this->successResponse('Registered successfully!', [
                'token' => $token
            ]);
        } catch (\Exception $e) {}

        return $this->errorResponse('Registration unsuccessful.');
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        try {
            $credentials = $request->only(['email', 'password']);
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $user->tokens()->delete();

                $token = $user->createToken('login_token')->plainTextToken;

                return $this->successResponse('Login successful!', [
                    'token' => $token
                ]);
            }
        } catch (\Exception $e) {}

        return $this->errorResponse('Wrong credentials.');
    }

    public function logout(): JsonResponse
    {
        try {
            $user = Auth::user();
            $user?->tokens()?->delete();
            Auth::logout();
        } catch (\Exception $e) {}

        return $this->successResponse('Logged out successfully!');
    }
}
