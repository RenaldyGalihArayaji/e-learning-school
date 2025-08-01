<?php

namespace App\Models;

use App\Models\Tugas;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'pegawai_id');
    }

    public function mataPelajaran()
    {
        return $this->hasMany(MataPelajaran::class, 'guru_pengampu_id');
    }
    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'pegawai_id');
    }

}
