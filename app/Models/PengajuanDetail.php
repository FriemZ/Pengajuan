<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanDetail extends Model
{
    protected $fillable = ['pengajuan_id', 'nim', 'nama'];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }
}
