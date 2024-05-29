<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function get_roles()
    {
        $roles = Role::all();
        return response()->json(['roles' => $roles], 200);
    }
    public function update_user_role(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $roles = $this->get_roles();
        $role_names = [];
        foreach ($roles as $role) {
            $role_names[] = $role->name;
        }
        if (!in_array($request->role, $role_names)) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $user->assignRole($request->role);
        return response()->json(['message' => 'Role assigned to user'], 200);
    }
}