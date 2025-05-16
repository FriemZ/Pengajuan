<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    // Display all users
    public function index()
    {
        $job = Job::all(); // Eager load job for better performance
        return view('dashboard.job', compact('job'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Simpan data user ke dalam database
        job::create([
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'User created successfully.');
    }



    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        // Validasi dasar
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Update data dasar
        $job->nama = $request->nama;

    
        $job->save();

        return redirect()->route('jobs.index')->with('success', 'jurus$job berhasil diperbarui.');
    }

    // Delete the user
    public function destroy($id)
    {
        Job::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User created successfully.');
    }
}
