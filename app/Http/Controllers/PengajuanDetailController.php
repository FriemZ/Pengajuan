<?php

namespace App\Http\Controllers;

use App\Models\PengajuanDetail;
use Illuminate\Http\Request;

class PengajuanDetailController extends Controller
{
    public function index()
    {
        return view('dashboard.infopengajuan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pengajuan_id' => 'required|exists:pengajuans,id',
            'nim' => 'required|string',
            'nama' => 'required|string',
        ]);

        PengajuanDetail::create($data);
        return redirect()->back()->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        PengajuanDetail::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Anggota berhasil dihapus.');
    }
}
