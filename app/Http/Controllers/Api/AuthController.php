<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'nip' => ['required', 'string'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::where('nip', $credentials['nip'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return ApiResponse::error('NIP atau password yang Anda masukkan salah.', 422, [
                'nip' => ['NIP atau password yang Anda masukkan salah.'],
            ]);
        }

        $deviceName = $credentials['device_name']
            ?? $request->userAgent()
            ?? 'flutter-android';

        return ApiResponse::success([
            'token_type' => 'Bearer',
            'token' => $user->createToken($deviceName)->plainTextToken,
            'user' => $this->userPayload($user),
        ], 'Login berhasil.');
    }

    public function me(Request $request): JsonResponse
    {
        return ApiResponse::success([
            'user' => $this->userPayload($request->user()),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return ApiResponse::success(null, 'Logout berhasil.');
    }

    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return ApiResponse::success(null, 'Semua token berhasil dicabut.');
    }

    private function userPayload(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'nip' => $user->nip,
            'email' => $user->email,
            'role' => $user->role,
        ];
    }
}
