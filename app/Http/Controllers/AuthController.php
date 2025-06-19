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

        // Ambil jumlah percobaan dari session
        $attempts = session()->get('login_attempts', 0);

        // Cek password
        if (!$user || !Hash::check($request->password, $user->password)) {
            $attempts++;
            session()->put('login_attempts', $attempts);

            // Jika lebih dari 2 percobaan salah (ke-3 kalinya)
            if ($attempts >= 3) {
                session()->forget('login_attempts'); // reset
                return response()->json([
                    'success' => false,
                    'redirect' => url('/'), // arahkan ke halaman awal atau halaman error
                    'message' => 'Terlalu banyak percobaan. Silakan coba lagi nanti.',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Password salah. Percobaan ke-' . $attempts . ' dari 3.',
            ]);
        }

        // Jika berhasil, reset percobaan
        session()->forget('login_attempts');

        // Login pengguna
        Auth::login($user);

        // Tentukan redirect berdasarkan role
        $redirectUrl = '/dashboard'; // default

        if ($user->role === 'mahasiswa') {
            $redirectUrl = url('/pengajuan');
        } else {
            $redirectUrl = url('/dashboard');
        }

        return response()->json([
            'success' => true,
            'redirect' => $redirectUrl, // pastikan ini benar
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
