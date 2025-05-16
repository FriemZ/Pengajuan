<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $fillable = [
        'user_id',
        'jenis',
        'tipe',
        'keperluan',
        'instansi',
        'alamat_instansi',
        'jangka_waktu',
        'file',
        'status'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PengajuanDetail::class);
    }

    public function koordinator()
    {
        return $this->belongsTo(Koordinator::class, 'koordinator_id');
    }


    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function dokumenSurat()
    {
        return $this->hasOne(DokumenSurat::class);
    }

    public function pembimbing()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_id');
    }

    public function anggota()
    {
        return $this->hasMany(Anggota::class);
    }
}
