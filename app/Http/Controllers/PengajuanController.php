<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Anggota;
use App\Models\Pengajuan;
use App\Models\DokumenSurat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PengajuanController extends Controller
{


    // Menampilkan form pengajuan
    public function create()
    {
        $mahasiswas = User::where('role', 'mahasiswa')
            ->where('id', '!=', auth()->id()) // tidak termasuk dirinya sendiri
            ->get();
        return view('dashboard.pengajuan', compact('mahasiswas'));
    }

    public function indexVerifikasi(Request $request)
    {
        $jenis = $request->get('jenis', 'skripsi');

        $pengajuans = Pengajuan::with(['user', 'dokumenSurat'])
            ->where('jenis', $jenis)
            ->orderByDesc('created_at')
            ->get();

        // Fetch dosens who have an active koordinator
        $dosens = Dosen::whereHas('koordinatorAktif', function ($query) {
            $query->where('aktif', true); // Only dosens with an active koordinator
        })->get();

        return view('dashboard.verif', compact('pengajuans', 'dosens', 'jenis'));
    }



    public function buatSurat(Request $request, $pengajuanId)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosens,id',
        ]);

        $pengajuan = Pengajuan::with('anggota.user')->findOrFail($pengajuanId);
        $dosen = Dosen::with('user')->findOrFail($request->dosen_id);
        $anggotaList = $pengajuan->anggota;

        $orientation = $pengajuan->tipe === 'kelompok' ? 'landscape' : 'portrait';

        // Buat nama file unik
        $filename = 'surat_pengantar_' . $pengajuan->id . '_' . now()->format('Ymd_His') . '_' . Str::random(4) . '.pdf';
        $relativePath = 'surat/' . $filename; // path untuk disimpan ke DB
        $fullPath = public_path($relativePath); // path fisik di public/

        // Pastikan folder 'public/surat' ada
        if (!file_exists(public_path('surat'))) {
            mkdir(public_path('surat'), 0755, true);
        }

        // Generate PDF dan simpan ke public/surat/
        $pdf = Pdf::loadView('surat.multiple', compact('pengajuan', 'dosen', 'anggotaList'))
            ->setPaper('a4', $orientation);
        $pdf->save($fullPath);

        // Simpan info surat ke DB
        DokumenSurat::create([
            'pengajuan_id' => $pengajuan->id,
            'dosen_id' => $dosen->id,
            'file_surat' => $relativePath,
        ]);

        // Update status pengajuan
        $pengajuan->status = 'disetujui';
        $pengajuan->save();

        return redirect()->back()->with('success', 'Surat berhasil dibuat dan disimpan di public/surat.');
    }

    public function tolakPengajuan($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status = 'ditolak';
        $pengajuan->save();

        return redirect()->route('admin.verifikasi', ['jenis' => $pengajuan->jenis])
            ->with('success', 'Pengajuan ditolak.');
    }

    public function setuju(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status = 'disetujui';
        $pengajuan->dosen_koordinator_id = $request->dosen_koordinator_id;
        $pengajuan->save();

        // Buat PDF surat
        $pdf = Pdf::loadView('surat.pdf', ['pengajuan' => $pengajuan]);

        $namaFile = 'surat_' . $pengajuan->id . '_' . time() . '.pdf';
        $filePath = 'dokumen_surat/' . $namaFile;

        // Simpan PDF ke storage/app/public/dokumen_surat
        Storage::disk('public')->put($filePath, $pdf->output());

        // Buat record dokumen_surat
        DokumenSurat::create([
            'pengajuan_id' => $pengajuan->id,
            'dosen_id' => $request->dosen_koordinator_id,
            'file_path' => 'storage/' . $filePath // supaya bisa diakses via public
        ]);

        return back()->with('success', 'Pengajuan disetujui & surat berhasil dibuat.');
    }

    public function tolak($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status = 'ditolak';
        $pengajuan->save();

        return back()->with('error', 'Pengajuan telah ditolak.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:magang,skripsi',
            'tipe' => 'required_if:jenis,magang|in:sendiri,kelompok',
            'instansi' => 'required_if:jenis,magang',
            'alamat_instansi' => 'required_if:jenis,magang',
            'jangka_waktu' => 'required_if:jenis,magang',
            'keperluan' => 'required',
            'file' => 'required_if:jenis,skripsi|mimes:pdf|max:5120', // max 5 MB
        ]);

        // Siapkan path file proposal
        $filePath = null;

        if ($request->jenis === 'skripsi' && $request->hasFile('file')) {
            $file = $request->file('file');
            $judul = preg_replace('/[^A-Za-z0-9\- ]/', '', $request->keperluan); // bersihkan nama file
            $fileName = $judul . '.' . $file->getClientOriginalExtension();

            // Simpan di public/skripsi/NAMA_FILE.pdf
            $file->move(public_path('skripsi'), $fileName);
            $filePath = 'skripsi/' . $fileName;
        }

        $pengajuan = Pengajuan::create([
            'user_id' => Auth::id(),
            'jenis' => $request->jenis,
            'tipe' => $request->tipe ?? 'sendiri', // default sendiri jika skripsi
            'keperluan' => $request->keperluan,
            'status' => 'menunggu',
            'file' => $filePath,
            'instansi' => $request->instansi ?? null,
            'alamat_instansi' => $request->alamat_instansi ?? null,
            'jangka_waktu' => $request->jangka_waktu ?? null,
        ]);

        // Proses anggota untuk magang kelompok
        if ($request->jenis === 'magang' && $request->tipe === 'kelompok') {
            $anggotaIds = $request->anggota_id ?? [];

            if (!is_array($anggotaIds)) {
                $anggotaIds = [$anggotaIds];
            }

            if (count($anggotaIds) > 1) {
                return back()->withErrors(['anggota_id' => 'Maksimal 1 anggota tambahan diperbolehkan.'])->withInput();
            }

            if (in_array(Auth::id(), $anggotaIds)) {
                return back()->withErrors(['anggota_id' => 'Anda tidak dapat memilih diri sendiri sebagai anggota.'])->withInput();
            }

            foreach ($anggotaIds as $anggotaId) {
                if ($anggotaId) {
                    Anggota::create([
                        'pengajuan_id' => $pengajuan->id,
                        'user_id' => $anggotaId,
                    ]);
                }
            }
        }

        return back()->with('success', 'Pengajuan berhasil dikirim.');
    }
}
