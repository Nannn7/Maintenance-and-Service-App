<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * List users. Previously this was wide open with zero auth
     * middleware (dumped the entire users table to any unauthenticated
     * caller). Now locked behind auth:sanctum + role:admin,management
     * at the route level (see routes/api.php) — this controller no
     * longer trusts itself as the only line of defense.
     */
    public function index(Request $request): JsonResponse
    {
        $users = User::query()
            ->when(
                $request->filled('role'),
                fn ($query) => $query->where('role', $request->string('role'))
            )
            ->orderBy('name')
            ->paginate($request->integer('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => UserResource::collection($users),
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'total' => $users->total(),
            ],
        ]);
    }
}
