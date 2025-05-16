<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Display all users
    public function index()
    {
        $users = User::with('jurusan')->get(); // Eager load jurusan for better performance
        return view('dashboard.user', compact('users'));
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
        // Validasi
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'nim' => 'nullable|unique:users,nim',
            'password' => 'required|string|min:3',
            'conf_pass' => 'required|string|same:password',  // Memastikan conf_pass sama dengan password
            'role' => 'required|in:admin,dosen,mahasiswa',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            // Simpan file foto di public/images
            $fotoPath = $request->file('foto')->move(public_path('images'), $request->file('foto')->getClientOriginalName());
        }

        // Simpan data user ke dalam database
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'nim' => $request->nim,
            'password' => Hash::make($request->password),  // Hash password
            'role' => $request->role,
            'jurusan_id' => $request->jurusan_id,
            'foto' => 'images/' . $request->file('foto')->getClientOriginalName(),
            'conf_pass' => $request->conf_pass,  // Menyimpan conf_pass tanpa di-hash
        ]);

        return redirect()->back()->with('success', 'User created successfully.');
    }




    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi dasar
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $id,
            'nim' => 'nullable|string|max:100',
            'role' => 'required|in:admin,dosen,mahasiswa',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'password' => 'nullable|string|min:6',
            'conf_pass' => 'nullable|same:password',
        ]);

        // Update foto jika diupload
        if ($request->hasFile('foto')) {
            // Simpan file foto di public/images
            $fotoPath = $request->file('foto')->move(public_path('images'), $request->file('foto')->getClientOriginalName());

            // Menyimpan nama file foto ke database
            $user->foto = 'images/' . $request->file('foto')->getClientOriginalName();
        }

        // Update data dasar
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->nim = $request->nim;
        $user->role = $request->role;
        $user->jurusan_id = $request->jurusan_id;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    // Delete the user
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User created successfully.');
    }
}
