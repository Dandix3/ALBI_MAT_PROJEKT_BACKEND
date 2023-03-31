<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthController extends Controller
{
    const ENDPOINT = "auth";

    public static function getEndpointUrl(): string {
        return self::ENDPOINT;
    }

    /**
     * @lrd:start
     * Hello markdown
     * Free `code` or *text* to write documentation in markdown
     * @lrd:end
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        Log::info('Registering user');
        try {
            $validateUser = $request->validated();
            $user = User::create([
                'first_name' => $validateUser['first_name'],
                'last_name' => $validateUser['last_name'],
                'nickname' => $validateUser['nickname'],
                'email' => $validateUser['email'],
                'password' => Hash::make($validateUser['password']),
            ]);
            $token = $user->createToken('REG TOKEN')->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => 'Uživatel byl úspěšně zaregistrován',
                'data' => $token,
            ], 201);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        Log::info('Logging in user');
        try {
            $validateUser = $request->validated();

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email nebo heslo je špatně.',
                ], 401);
            }

            $user = User::where('email', $validateUser['email'])->first();


            return response()->json([
                'status' => true,
                'message' => 'Přihlášení proběhlo úspěšně.',
                'data' => $user->createToken("API TOKEN")->plainTextToken,
            ]);

        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Odhlášení proběhlo úspěšně.',
        ]);
    }
}
