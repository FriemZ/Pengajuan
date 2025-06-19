<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jumlahDosen = Dosen::count();
        $jumlahMahasiswa = User::where('role', 'mahasiswa')->count(); // ambil dari tabel users
        $jumlahJurusan = Jurusan::count();
        $jumlahPengajuan = Pengajuan::where('status','menunggu')->count();

        $pengajuans = [];

        if (auth()->user()->role === 'dosen') {
            $dosenId = auth()->user()->dosen->id ?? null;

            if ($dosenId) {
                $pengajuans = Pengajuan::with('user') // relasi ke mahasiswa
                    ->where('jenis', 'skripsi')
                    ->where('dosen_id', $dosenId)
                    ->where('status', 'menunggu')
                    ->orderByDesc('created_at')
                    ->get();
            }
        }

        return view('dashboard.dashboard', compact('pengajuans', 'jumlahDosen', 'jumlahMahasiswa', 'jumlahJurusan', 'jumlahPengajuan'));
    }

    public function verifikasi(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        if (auth()->user()->dosen->id != $pengajuan->dosen_id) {
            abort(403); // Hanya dosen terkait yang bisa verifikasi
        }

        $request->validate([
            'status' => 'in:disetujui,ditolak',
        ]);
        $pengajuan->status = $request->status;
        $pengajuan->catatan = $request->catatan;
        $pengajuan->save();

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
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
