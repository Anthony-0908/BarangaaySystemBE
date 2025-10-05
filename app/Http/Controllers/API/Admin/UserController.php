<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     // ✅ Only users with the "admin" role can access any method here
    //     $this->middleware(['role:Admin']);
    // }

    public function index(Request $request): JsonResponse
    {
        try {
            $query = User::with('roles');

            if ($search = $request->input('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            $sortBy = $request->input('sortBy', 'id');
            $sortDir = $request->input('sortDir', 'desc');
            $query->orderBy($sortBy, $sortDir);

            $perPage = max((int) $request->input('perPage', 10), 1);
            $users = $query->paginate($perPage);

            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        return response()->json([
            'message' => 'User successfully created',
            'data' => $user,
        ]);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function update(StoreUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());
        $user['password'] = bcrypt($user['password']);

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
