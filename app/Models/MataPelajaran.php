<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\Pegawai;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function guruPengampu()
    {
        return $this->belongsTo(Pegawai::class, 'guru_pengampu_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'mata_pelajaran_id');
    }
}
