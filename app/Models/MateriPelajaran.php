<?php

namespace App\Models;

use App\Models\Pegawai;
use App\Models\MataPelajaran;
use Illuminate\Database\Eloquent\Model;

class MateriPelajaran extends Model
{
    protected $table = 'materi_pelajaran';
    protected $guarded = ['id'];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
