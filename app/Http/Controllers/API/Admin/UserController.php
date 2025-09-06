<?php

namespace App\Http\Controllers\API\Admin;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::with('roles');

        
    if ($search = $request->input('search')) {
        $query->where(function($q) use ($search) { 
            $q->where('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%");
        });
    }
            $sortBy = $request->input('sortBy', 'created_at');
            $sortDir = $request->input('sortDir' , 'desc');
            $query->orderBy($sortBy, $sortDir);

            $perPage = $request->input('perPage',10);
            $users = $query->paginate($perPage);

            return response()->json($users);

        // return response()->json(['message' => 'Try new ']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']); // hash it

        $user = User::create($request->validated());

        return response()->json([
            'message' => 'User successfully created',
            'data' => $user,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, User $user): JsonResponse
    {
        $user = User::update($request->validated());

        return response()->json([
            'message' => 'Resident updated successfully',
            'data'    => $resident
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
