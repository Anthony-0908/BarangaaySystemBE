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
            'permission' => 'required|string|exists:permissions,name',
        ]);

        $role = Role::findOrFail($roleId);
        $permissionName = $request->permission;

        if ($role->hasPermissionTo($permissionName)) {
            // Remove if exists
            $role->revokePermissionTo($permissionName);
            $status = 'revoked';
        } else {
            // Assign if not exists
            $role->givePermissionTo($permissionName);
            $status = 'granted';
        }

        return response()->json([
            'message' => "Permission '{$permissionName}' {$status} for role '{$role->name}'",
            'role' => $role->name,
            'permission' => $permissionName,
            'status' => $status
        ]);
    }


    public function toggleUserPermission(Request $request, $userId)
{
    $request->validate([
        'permission' => 'required|string|exists:permissions,name',
    ]);

    $user = \App\Models\User::findOrFail($userId);
    $permissionName = $request->permission;

    if ($user->hasPermissionTo($permissionName)) {
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
