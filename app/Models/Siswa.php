<?php

namespace App\Models;

use App\Models\User;
use App\Models\Kelas;
use App\Models\PengumpulanTugas;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
     protected $table = 'siswa';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class, 'siswa_id', 'siswa_id');
    }

}
