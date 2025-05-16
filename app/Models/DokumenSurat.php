<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenSurat extends Model
{
    // Tambahkan ini:
    protected $table = 'dokumen_surat';


    protected $fillable = ['pengajuan_id', 'dosen_id', 'file_surat'];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
