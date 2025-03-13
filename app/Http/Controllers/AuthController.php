<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // Метод для регистрации
    public function register(RegisterRequest $request)
    {
        // Создаем нового пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Возвращаем ресурс пользователя с HTTP статусом 201
        return new UserResource($user);
    }

    // Метод для авторизации
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Пытаемся выполнить авторизацию с использованием JWT
        if ($token = JWTAuth::attempt($credentials)) {
            // Генерация refresh токена
            $refreshToken = JWTAuth::getToken();
            $refreshToken = JWTAuth::refresh($refreshToken); // Обновление токена

            return response()->json([
                'token' => $token,
                'refresh_token' => $refreshToken // Возвращаем refresh токен
            ], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Метод для получения информации о текущем авторизованном пользователе
    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    // Метод для разлогирования пользователя
    public function logout(Request $request)
    {
        // Отзываем токен пользователя
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    // Метод для получения списка авторизованных токенов
    public function tokens(Request $request)
    {
        $tokens = $request->user()->tokens;

        return response()->json(['tokens' => $tokens]);
    }

    // Метод для отзыва всех токенов
    public function revokeAllTokens(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'All tokens revoked'], 200);
    }

    // Метод для смены пароля
    public function changePassword(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($validated['old_password'], $user->password)) {
            return response()->json(['error' => 'Old password is incorrect'], 400);
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return response()->json(['message' => 'Password updated successfully'], 200);
    }

    // Метод для обновления токена
    public function refresh(Request $request)
    {
        try {
            // Проверка refresh токена и генерация нового токена
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json([
                'token' => $newToken
            ]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not refresh token'], 500);
        }
    }
}

