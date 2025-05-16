<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koordinator extends Model
{
     protected $table = 'koordinator';

    protected $fillable = ['dosen_id', 'job_position_id', 'aktif'];



    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function jobPosition()
    {
        return $this->belongsTo(Job::class);
    }
}
