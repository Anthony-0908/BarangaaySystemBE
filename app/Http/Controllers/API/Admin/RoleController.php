<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $roles =  Role::create(['name' => $request->name]);
        return response()->json([
            'message' => 'Role successfully created',
            'data' => $roles,   
          
        ],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findById($id);

        $request->validate([
            'name' => 'required|string|unique:roles,name,'.$role->id,
        ]);

        $role->name = $request->name;
        $role->save();

        return response()->json([
            'message' => 'Role successfully updated',
            'data' => $role,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findById($id);
        $role->delete();

        return reponse()->json(['message' => 'Role successfully deleted'],200);
    }
}
