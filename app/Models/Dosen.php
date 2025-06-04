<?php

namespace App\Models;

use App\Models\Koordinator;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $fillable = ['user_id', 'jabatan', 'ttd_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Di App\Models\Dosen.php
    public function jobPosition()
    {
        // Contoh jika foreign key adalah job_position_id dan model JobPosition
        return $this->belongsTo(job::class, 'job_position_id');
    }


    public function koordinatorAktif()
    {
        return $this->hasOne(Koordinator::class)->where('aktif', true);
    }

    public function isKoordinatorAktif(): bool
    {
        return $this->koordinatorAktif()->exists();
    }
}
