<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusans';

    protected $fillable = ['nama'];

    public function mahasiswa()
    {
        return $this->hasMany(User::class)->where('role', 'mahasiswa');
    }

    public function dosens()
    {
        return $this->hasMany(Dosen::class);
    }
}
