<?php

namespace App\Http\Controllers\Master;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Pegawai;
use App\Models\PengumpulanTugas;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Mendapatkan tahun ajaran aktif
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        // Lakukan pengecekan, jika tidak ada tahun ajaran aktif, beri nilai default
        if ($tahunAjaranAktif) {
            $namaTahunAjaran = $tahunAjaranAktif->nama_tahun_ajaran;
        } else {
            $namaTahunAjaran = "Tidak ada tahun ajaran aktif";
        }

        $user = Auth::user();

        // Inisialisasi variabel dengan nilai default
        $jumlahSiswa = 0;
        $jmlKelas = 0;
        $jmlMapel = 0;
        $jmlGuru = 0;

        $tugas = collect();
        $jumlahTugasTerkumpul = 0;
        $jumlahTugasBelumTerkumpul = 0;

        // Mendapatkan peran (role) pengguna yang login
        $roles = $user->roles->pluck('name')->toArray();

        // Logika perhitungan berdasarkan role
        if (in_array('super-admin', $roles)) {
            // Jika Super Admin, hitung semua data
            $jumlahSiswa = Siswa::count();
            $jmlKelas = Kelas::count();
            $jmlMapel = MataPelajaran::count();
            $jmlGuru = Pegawai::whereHas('user.roles', function ($query) {
                $query->where('name', 'guru');
            })->count();
        } elseif (in_array('guru', $roles)) {
            // Jika Guru, hitung data sesuai pegawai_id
            $pegawaiId = $user->pegawai->id ?? null;
            if ($pegawaiId) {
                // Menghitung jumlah kelas yang diampu oleh guru
                $jmlKelas = Kelas::where('pegawai_id', $pegawaiId)->count();

                // Mengambil ID kelas yang diampu oleh guru
                $kelasIds = Kelas::where('pegawai_id', $pegawaiId)->pluck('id');

                // Menghitung jumlah siswa di kelas yang diampu
                $jumlahSiswa = Siswa::whereIn('kelas_id', $kelasIds)->count();

                // Menghitung jumlah mata pelajaran yang diampu oleh guru
                $jmlMapel = MataPelajaran::where('guru_pengampu_id', $pegawaiId)->count();
            }
        } elseif (in_array('siswa', $roles)) {
            // Jika Siswa, hitung data terkait kelasnya
            $siswa = $user->siswa;
            if ($siswa) {
                $kelasId = $siswa->kelas_id;
                $siswaId = $siswa->id;

                if ($kelasId) {
                    $jmlKelas = 1; // Siswa hanya terkait dengan 1 kelas
                    $jumlahSiswa = Siswa::where('kelas_id', $kelasId)->count();
                    $jmlMapel = MataPelajaran::where('kelas_id', $kelasId)->count();

                    // Logika untuk mengambil data tugas (khusus siswa)
                    $tugas = Tugas::with(['mataPelajaran'])
                        ->whereHas('mataPelajaran', function ($query) use ($kelasId) {
                            $query->where('kelas_id', $kelasId);
                        })
                        ->whereDoesntHave('pengumpulanTugas', function ($query) use ($siswaId) {
                            $query->where('siswa_id', $siswaId);
                        })
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

                    // Perhitungan total tugas untuk kelas tersebut
                    $tugasIds = Tugas::whereHas('mataPelajaran', function ($query) use ($kelasId) {
                        $query->where('kelas_id', $kelasId);
                    })->pluck('id');

                    $jumlahTugasTerkumpul = PengumpulanTugas::where('siswa_id', $siswaId)
                        ->whereIn('tugas_id', $tugasIds)
                        ->count();

                    $jumlahTugasBelumTerkumpul = count($tugasIds) - $jumlahTugasTerkumpul;
                }
            }
        }

        return view('master.dashboard', [
            'title' => 'Dashboard',
            'namaTahunAjaran' => $namaTahunAjaran,
            'jumlahSiswa' => $jumlahSiswa,
            'jmlKelas' => $jmlKelas,
            'tugas' => $tugas,
            'jmlMapel' => $jmlMapel,
            'jumlahTugasTerkumpul' => $jumlahTugasTerkumpul,
            'jumlahTugasBelumTerkumpul' => $jumlahTugasBelumTerkumpul,
            'jmlGuru' => $jmlGuru
        ]);
    }
}
