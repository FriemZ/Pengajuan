<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('dashboard.dashboard');
    }

    public function updateTtd(Request $request, $id)
    {
        $request->validate([
            'ttd_path' => 'required|image|max:2048',
        ]);

        $dosen = Dosen::findOrFail($id);

        if ($request->hasFile('ttd_path')) {
            $ttdFile = $request->file('ttd_path');
            $ttdName = $ttdFile->getClientOriginalName();
            $ttdPath = 'ttd/' . $ttdName;
            $ttdFile->move(public_path('ttd'), $ttdName); // pindah ke public/ttd
            $dosen->ttd_path = $ttdPath; // simpan path ke database
            $dosen->save();
        }


        return redirect()->back()->with('success', 'Tanda tangan berhasil diupload.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
