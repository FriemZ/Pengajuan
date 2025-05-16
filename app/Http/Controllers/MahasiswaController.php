<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    // Display all users
    public function index()
    {
        $users = User::where('role', 'mahasiswa')->with('jurusan')->get(); // Eager load jurusan for better performance
        return view('dashboard.mahasiswa', compact('users'));
    }



    // Show the form for editing the user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $jurusans = Jurusan::all(); // Fetch all jurusan for the dropdown
        return response()->json([
            'user' => $user,
            'jurusans' => $jurusans,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'nim' => 'nullable|unique:users,nim',
            'password' => 'required|string|min:3|same:conf_pass',
            'conf_pass' => 'required|string|same:password',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'ttd_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Simpan foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            // Menggunakan nama asli untuk foto
            $fotoFile = $request->file('foto');
            $fotoPath = $fotoFile->storeAs('images', 'foto_' . time() . '.' . $fotoFile->getClientOriginalExtension(), 'public');
        }

        // Simpan tanda tangan jika ada
        $ttdPath = null;
        if ($request->hasFile('ttd_path')) {
            // Menggunakan nama asli untuk tanda tangan
            $ttdFile = $request->file('ttd_path');
            $ttdPath = $ttdFile->storeAs('ttd', 'ttd_' . time() . '.' . $ttdFile->getClientOriginalExtension(), 'public');
        }

        // Simpan data user
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'nim' => $request->nim,
            'password' => Hash::make($request->password),
            'jurusan_id' => $request->jurusan_id, // pastikan ini diisi
            'foto' => $fotoPath, // Simpan path foto
            'role' => 'mahasiswa', // auto role mahasiswa
            'conf_pass' => $request->conf_pass, // pastikan conf_pass diisi
        ]);

        return redirect()->back()->with('success', 'User created successfully.');
    }



    public function update(Request $request, $id)
    {
        $mahasiswa = User::findOrFail($id);

        // Validasi dasar
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $id,
            'nim' => 'nullable|string|max:100',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Maksimal 5MB
            'password' => 'nullable|string|min:6',
            'conf_pass' => 'nullable|same:password',
        ]);

        // Update foto jika ada yang diupload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($mahasiswa->foto && file_exists(public_path($mahasiswa->foto))) {
                unlink(public_path($mahasiswa->foto)); // Menghapus file lama
            }

            // Simpan foto baru
            $foto = $request->file('foto');
            $fotoName = 'foto_' . time() . '.' . $foto->getClientOriginalExtension();
            $fotoPath = $foto->move(public_path('images'), $fotoName);

            // Menyimpan path foto baru
            $mahasiswa->foto = 'images/' . $fotoName; // Menyimpan foto dengan path relatif
        }

        // Update data dasar
        $mahasiswa->nama = $request->nama;
        $mahasiswa->email = $request->email;
        $mahasiswa->nim = $request->nim;
        $mahasiswa->jurusan_id = $request->jurusan_id;

        // Update password jika diisi
        if ($request->filled('password')) {
            $mahasiswa->password = Hash::make($request->password);
        }

        $mahasiswa->save();

        return redirect()->route('mahasiswas.index')->with('success', 'User berhasil diperbarui.');
    }


    // Delete the user
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User created successfully.');
    }
}
