<?php

namespace App\Models;

use App\Models\MataPelajaran;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'tahun_ajaran_id');
    }

    public function mataPelajaran()
    {
        return $this->hasMany(MataPelajaran::class, 'tahun_ajaran_id');
    }
}
