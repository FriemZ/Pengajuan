<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Koordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    // Display all users
    public function index()
    {
        $dosens = Dosen::whereHas('user', function ($query) {
            $query->where('role', 'dosen');
        })->with('user', 'jurusan')->get();
        $job_positions = Job::all(); // ambil semua posisi jabatan
        return view('dashboard.dosen', compact('dosens', 'job_positions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'nullable|string|max:50|unique:dosens,nip',
            'password' => 'required|string|min:3|same:conf_pass',
            'conf_pass' => 'required|string|same:password',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'ttd_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'jabatan' => 'nullable|string|max:255',
            'jurusan_id' => 'nullable|exists:jurusans,id',
        ]);

        // Simpan data user
        $user = new User();
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->conf_pass = $request->conf_pass;
        $user->role = 'dosen';
        $user->jurusan_id = $request->jurusan_id; // <-- TAMBAHKAN INI
        $user->password = Hash::make($request->password);

        if ($request->hasFile('foto')) {
            $fotoFile = $request->file('foto');
            $fotoName = $fotoFile->getClientOriginalName();
            $fotoPath = 'images/' . $fotoName; // direktori di dalam folder public
            $fotoFile->move(public_path('images'), $fotoName); // pindah ke public/images
            $user->foto = $fotoPath; // simpan path ke database
        }



        $user->save();

        // Simpan data dosen
        $dosen = new Dosen();
        $dosen->user_id = $user->id;
        $dosen->jabatan = $request->jabatan;
        $dosen->nip = $request->nip;

        if ($request->hasFile('ttd_path')) {
            $ttdFile = $request->file('ttd_path');
            $ttdName = $ttdFile->getClientOriginalName();
            $ttdPath = 'ttd/' . $ttdName;
            $ttdFile->move(public_path('ttd'), $ttdName); // pindah ke public/ttd
            $dosen->ttd_path = $ttdPath; // simpan path ke database
        }

        $dosen->save();

        return redirect()->back()->with('success', 'Dosen created successfully.');
    }


    // KoordinatorController.php

    public function setKoordinator(Request $request)
    {
        // Validasi data koordinator
        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
            'job_position_id' => 'required|exists:job_positions,id',
        ]);

        // Simpan koordinator baru tanpa menonaktifkan yang lain
        Koordinator::create([
            'dosen_id' => $request->dosen_id,
            'job_position_id' => $request->job_position_id,
            'aktif' => true, // biarkan lebih dari satu koordinator aktif
        ]);

        return response()->json(['success' => true, 'message' => 'Koordinator berhasil diset']);
    }


    // KoordinatorController.php

    // DosenController.php

    public function hapusKoordinator(Request $request)
    {
        // Validasi dosen_id yang dikirimkan
        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
        ]);

        // Temukan koordinator dengan dosen_id yang diberikan
        $koordinator = Koordinator::where('dosen_id', $request->dosen_id)->first();

        $koordinator->delete();
        return redirect()->back()->with('success', 'Dosen created successfully.');
    }





    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'nip' => 'required|string|max:50',
            'jabatan' => 'required|string|max:100',
            'jurusan_id' => 'required|exists:jurusans,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ttd_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil user dan relasi dosennya
        $user = User::findOrFail($id);
        $dosen = $user->dosen;

        if (!$dosen) {
            return back()->with('error', 'Data dosen tidak ditemukan.');
        }

        // Update data user
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->jurusan_id = $request->jurusan_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            $fotoFile = $request->file('foto');
            $fotoName = $fotoFile->getClientOriginalName();
            $fotoPath = 'images/' . $fotoName; // direktori di dalam folder public
            $fotoFile->move(public_path('images'), $fotoName); // pindah ke public/images
            $user->foto = $fotoPath; // simpan path ke database
        }

        $user->save();

        // Update data dosen
        $dosen->nip = $request->nip;
        $dosen->jabatan = $request->jabatan;

        if ($request->hasFile('ttd_path')) {
            $ttdFile = $request->file('ttd_path');
            $ttdName = $ttdFile->getClientOriginalName();
            $ttdPath = 'ttd/' . $ttdName;
            $ttdFile->move(public_path('ttd'), $ttdName); // pindah ke public/ttd
            $dosen->ttd_path = $ttdPath; // simpan path ke database
        }

        $dosen->save();

        return redirect()->back()->with('success', 'Dosen created successfully.');
    }


    // Delete the user
    public function destroy($id)
    {
        // Cari data dosen berdasarkan ID
        $dosen = Dosen::findOrFail($id);

        // Ambil user terkait dosen
        $user = $dosen->user;

        // Hapus file foto jika ada dan file tersebut ada di penyimpanan
        if ($dosen->foto && Storage::disk('public')->exists($dosen->foto)) {
            Storage::disk('public')->delete($dosen->foto);
        }

        // Hapus file tanda tangan (ttd_path) jika ada dan file tersebut ada di penyimpanan
        if ($dosen->ttd_path && Storage::disk('public')->exists($dosen->ttd_path)) {
            Storage::disk('public')->delete($dosen->ttd_path);
        }

        // Hapus data dosen
        $dosen->delete();

        // Hapus data user terkait dosen jika ada
        if ($user) {
            $user->delete();
        }

        // Kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data dosen dan user berhasil dihapus.');
    }
}
