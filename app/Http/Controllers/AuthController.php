<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Student;
use App\Teacher;
use App\ClassRoom;

class AuthController extends Controller
{
    public function login()
    {
        $totalSiswa = Student::count();
        $totalGuru  = Teacher::count();
        $totalKelas = ClassRoom::count();

        return view('auth.login', compact('totalSiswa', 'totalGuru', 'totalKelas'));
    }

    public function proses(Request $request)
    {
        if (Auth::attempt($request->only('username', 'password'))) {
            if (auth()->user()->role == 'admin') {
                return redirect('/dashboard');
            } elseif (auth()->user()->role == 'siswa') {
                return redirect('/student/dashboard');
            } else {
                return redirect('/teacher/dashboard');
            }
        }

        return redirect('/')->with('status', 'username atau password salah!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function showChangePasswordForm()
    {
        return view('auth.changepassword');
    }

    public function changePassword(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        if (!(strcmp($request->get('new-password'), $request->get('new-password-confirm'))) == 0) {
            return redirect()->back()->with("error", "New Password should be same as your confirmed password. Please retype new password.");
        }

        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("status", "Password berhasil diubah !");
    }
}