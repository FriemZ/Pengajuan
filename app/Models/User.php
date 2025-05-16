<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'nim',
        'password',
        'role',
        'jurusan_id',
        'foto',
        'conf_pass'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function dosen()
    {
        return $this->hasOne(Dosen::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
