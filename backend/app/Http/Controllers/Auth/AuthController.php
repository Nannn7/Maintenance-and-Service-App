<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Public self-registration. Always provisions a 'reporter' account —
     * the only role allowed to self-serve per PRD. Admin / technician /
     * management accounts are provisioned internally by an admin (not
     * exposed here on purpose, and NOT taken from client input — never
     * trust a client-supplied role field for privilege assignment).
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->string('name'),
            'email' => $request->string('email'),
            'password' => Hash::make($request->string('password')),
            'phone_number' => $request->input('phone_number'),
            'role' => User::ROLE_REPORTER,
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'data' => new UserResource($user),
        ], 201);
    }

    /**
     * Sanctum SPA cookie-based login. The Next.js client MUST GET
     * /sanctum/csrf-cookie first (auto-registered by Sanctum's service
     * provider) so the XSRF-TOKEN cookie is present and echoed back as
     * the X-XSRF-TOKEN header on this request.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        if (! $user->is_active) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => ['This account has been deactivated. Contact an administrator.'],
            ]);
        }

        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'data' => new UserResource($user),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logged out.',
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new UserResource($request->user()),
        ]);
    }
}
