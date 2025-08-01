<?php

namespace App\Models;

use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\Pegawai;
use App\Models\TahunAjaran;
use App\Models\MataPelajaran;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $guarded = ['id'];

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function mataPelajaran()
    {
        return $this->hasMany(MataPelajaran::class, 'kelas_id');
    }
    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'kelas_id');
    }
}
