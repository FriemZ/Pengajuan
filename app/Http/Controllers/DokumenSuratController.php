<?php

namespace App\Http\Controllers;

use App\Models\DokumenSurat;
use Illuminate\Http\Request;

class DokumenSuratController extends Controller
{
    public function index()
    {
        $surats = DokumenSurat::with(['pengajuan.user', 'dosen'])->get();
        return view('surat.index', compact('surats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pengajuan_id' => 'required|exists:pengajuans,id',
            'dosen_id' => 'required|exists:dosens,id',
            'file_path' => 'required|string', // atau 'file' => 'file|mimes:pdf,jpg,png'
        ]);

        DokumenSurat::create($data);
        return redirect()->back()->with('success', 'Surat berhasil dibuat.');
    }

    public function destroy($id)
    {
        DokumenSurat::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Surat berhasil dihapus.');
    }
}
