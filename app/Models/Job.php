<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'job_positions';

    protected $fillable = ['nama'];
    

    public function dosens()
    {
        return $this->hasMany(Dosen::class);
    }
}
