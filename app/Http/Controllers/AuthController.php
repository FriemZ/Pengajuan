<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function checkName(Request $request)
    {
        $user = User::where('nama', $request->nama)->first();

        if ($user) {
            return response()->json(['success' => true, 'user_id' => $user->id]);
        }

        return response()->json(['success' => false, 'message' => 'Nama tidak ditemukan']);
    }

    public function checkPassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'userId' => 'required|exists:users,id',
        ]);

        $user = User::find($request->userId);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah',
            ]);
        }

        // Login pengguna
        Auth::login($user);

        return response()->json([
            'success' => true,
            'redirect' => url('/dashboard'), // pastikan ini benar
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Hapus session
        $request->session()->regenerateToken(); // Regenerasi CSRF token

        return redirect('/'); // Atau redirect ke login page
    }
}
