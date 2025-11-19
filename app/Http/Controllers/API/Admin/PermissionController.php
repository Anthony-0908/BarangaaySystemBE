<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function togglePermission(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required',
            'permission.*' => 'string|exists:permissions,name'
        ]);

        $role = Role::findOrFail($roleId);

        // Normalize to an array
        $permissions = is_array($request->permission)
            ? $request->permission
            : [$request->permission];

        $results = [];

        foreach ($permissions as $permissionName) {
            if ($role->hasPermissionTo($permissionName)) {
                $role->revokePermissionTo($permissionName);
                $status = 'revoked';
            } else {
                $role->givePermissionTo($permissionName);
                $status = 'granted';
            }

            $results[] = [
                'permission' => $permissionName,
                'status' => $status
            ];
        }

        return response()->json([
            'role' => $role->name,
            'results' => $results
        ]);
    }

    public function bulkInsert(Request $request)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'string'
        ]);

        $inserted = [];
        $skipped = [];

        foreach ($request->permissions as $perm) {
            // Skip if already exists
            if (Permission::where('name', $perm)->exists()) {
                $skipped[] = $perm;
                continue;
            }

            $inserted[] = Permission::create([
                'name' => $perm,
                'guard_name' => 'web'
            ]);
        }

        return response()->json([
            'message' => 'Bulk insert complete',
            'inserted' => $inserted,
            'skipped_existing' => $skipped
        ]);
    }


    public function toggleUserPermission(Request $request, $userId)
{
    $request->validate([
        'permission' => 'required|string|exists:permissions,name',
    ]);

    $user = \App\Models\User::findOrFail($userId);
    $permissionName = $request->permission;

    if ($user->hasPermissionTo($permissionName, 'api')) {
        $user->revokePermissionTo($permissionName);
        $status = 'revoked';
    } else {
        $user->givePermissionTo($permissionName);
        $status = 'granted';
    }

    return response()->json([
        'message' => "Permission '{$permissionName}' {$status} for user '{$user->name}'",
        'user' => $user->name,
        'permission' => $permissionName,
        'status' => $status
    ]);
}
}
