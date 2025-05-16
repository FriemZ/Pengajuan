<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
    ];

    /**
     * Relasi ke model User (setiap mahasiswa adalah user).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tambahan jika ingin menampilkan nama langsung.
     */
    public function getNamaAttribute()
    {
        return $this->user->name;
    }
}
