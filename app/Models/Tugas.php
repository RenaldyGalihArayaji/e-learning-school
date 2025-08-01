<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Pegawai;
use App\Models\MataPelajaran;
use App\Models\PengumpulanTugas;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';
    protected $guarded = ['id'];


    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class, 'tugas_id');
    }
}
