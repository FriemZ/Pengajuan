<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.profil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Update jika ada input, jika kosong gunakan nama lama
        $user->nama = $request->input('nama', $user->nama);
        $user->email = $request->input('email', $user->email);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && file_exists(public_path($user->foto))) {
                unlink(public_path($user->foto));
            }

            $file = $request->file('foto');
            $filename = $file->getClientOriginalName(); // nama asli file
            $destinationPath = public_path('images');

            // Pindahkan file ke folder public/images dengan nama asli
            $file->move($destinationPath, $filename);

            // Simpan path relatif ke db, misal 'images/namafile.jpg'
            $user->foto = 'images/' . $filename;
        }


        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
