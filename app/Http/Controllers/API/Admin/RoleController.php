<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
class RoleController extends Controller
{
     // List all roles with permissions
    public function index(Request $request)
    {
        $query = Role::with('permissions');

        if($search = $request->input('search')){
            $query->where('name', 'like', "%{$search}%");
        }

        $sortBy = $request->input('sortBy', 'id');
        $sortDir = $request->input('sortDir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        $perPage = max((int) $request->input('perPage', 10), 1);
        $roles = $query->paginate($perapage);
        // return response()->json(Role::with('permissions')->get());
    }

    // Store new role
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'api', // since API-only
        ]);

        return response()->json($role, 201);
    }

    // Show a role with permissions
    public function show($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return response()->json($role);
    }

    // Update a role
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $validated['name']]);

        return response()->json($role);
    }

    // Delete a role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }

    // Attach permissions to a role
    public function syncPermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'permissions' => 'array|required',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role->syncPermissions($validated['permissions']);

        return response()->json([
            'message' => 'Permissions synced successfully',
            'role' => $role->load('permissions')
        ]);
    }
}
