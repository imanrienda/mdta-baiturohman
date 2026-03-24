<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('user-role.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('user-role.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'username' => 'required|string|max:10|unique:users,username,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $request->username,
        ];

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Sinkronisasi Spatie roles
        if ($request->roles) {
            $user->syncRoles($request->roles);
            $user->update(['role' => $request->roles[0]]);
        } else {
            $user->syncRoles([]);
            $user->update(['role' => '']);
        }

        return redirect()->route('user-role.index')
            ->with('success', 'User ' . $user->name . ' berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return redirect()->route('user-role.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri!');
        }
        $user->delete();
        return redirect()->route('user-role.index')
            ->with('success', 'User ' . $user->name . ' berhasil dihapus');
    }
}