<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class JurusanController extends Controller
{
    // Display all users
    public function index()
    {
        $jurusan = Jurusan::all(); // Eager load jurusan for better performance
        return view('dashboard.jurusan', compact('jurusan'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Simpan data user ke dalam database
        Jurusan::create([
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'User created successfully.');
    }



    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);

        // Validasi dasar
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Update data dasar
        $jurusan->nama = $request->nama;

    
        $jurusan->save();

        return redirect()->route('jurusans.index')->with('success', 'jurus$jurusan berhasil diperbarui.');
    }

    // Delete the user
    public function destroy($id)
    {
        Jurusan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User created successfully.');
    }
}
