<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    public function index()
    {
        $users = User::with('permissions')->get();
        return view('user-permission.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $permissions = Permission::all();
        return view('user-permission.edit', compact('user', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->syncPermissions($request->permissions ?? []);
        return redirect()->route('user-permission.index')
            ->with('success', 'Permission untuk user ' . $user->name . ' berhasil diupdate');
    }
}