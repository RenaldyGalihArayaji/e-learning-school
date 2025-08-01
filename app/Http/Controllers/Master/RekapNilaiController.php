<?php

namespace App\Http\Controllers\Master;

use App\Models\Kelas;
use App\Models\Pegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Models\PengumpulanTugas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RekapNilaiController extends Controller
{
    public function exportSiswa(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        if (!$siswa) {
            return redirect()->back()->with('error', 'Anda tidak terdaftar sebagai siswa.');
        }

        $query = PengumpulanTugas::whereHas('siswa', function ($q) use ($siswa) {
            $q->where('id', $siswa->id);
        })->with(['tugas.mataPelajaran.guruPengampu']);

        if ($request->mata_pelajaran_id) {
            $query->whereHas('tugas.mataPelajaran', function ($q) use ($request) {
                $q->where('id', $request->mata_pelajaran_id);
            });
        }

        $pengumpulanTugas = $query->get();

        $pdf = PDF::loadView('master.rekap-nilai.export-pdf-siswa', [
            'pengumpulanTugas' => $pengumpulanTugas
        ]);
        return $pdf->download('rekap-nilai-siswa.pdf');
    }

    public function export(Request $request)
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name')->toArray();
        $query = PengumpulanTugas::with(['siswa.kelas', 'tugas.mataPelajaran.guruPengampu']);

        if (in_array('super-admin', $roles)) {
            // super-admin bisa melihat semua data
        } else if (in_array('guru', $roles)) {
            $query->whereHas('tugas.mataPelajaran.guruPengampu', function ($q) use ($user) {
                $q->where('id', $user->pegawai->id);
            });
        } else {
            $query->whereRaw('1=0');
        }

        if ($request->mata_pelajaran_id) {
            $query->whereHas('tugas.mataPelajaran', function ($q) use ($request) {
                $q->where('id', $request->mata_pelajaran_id);
            });
        }
        if ($request->kelas_id) {
            $query->whereHas('siswa.kelas', function ($q) use ($request) {
                $q->where('id', $request->kelas_id);
            });
        }
        if ($request->pegawai_id) {
            $query->whereHas('tugas.mataPelajaran.guruPengampu', function ($q) use ($request) {
                $q->where('id', $request->pegawai_id);
            });
        }

        $pengumpulanTugas = $query->get();

        $pdf = PDF::loadView('master.rekap-nilai.export-pdf', [
            'pengumpulanTugas' => $pengumpulanTugas
        ]);
        return $pdf->download('rekap-nilai.pdf');
    }

    public function index()
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name')->toArray();
        $query = PengumpulanTugas::with(['siswa.kelas', 'tugas.mataPelajaran.guruPengampu']);

        if (in_array('super-admin', $roles)) {
        } else if (in_array('guru', $roles)) {
            $query->whereHas('tugas.mataPelajaran.guruPengampu', function ($q) use ($user) {
                $q->where('id', $user->pegawai->id);
            });
        } else {
            $query->whereRaw('1=0');
        }

        // Filter berdasarkan request
        if (request('mata_pelajaran_id')) {
            $query->whereHas('tugas.mataPelajaran', function ($q) {
                $q->where('id', request('mata_pelajaran_id'));
            });
        }
        if (request('kelas_id')) {
            $query->whereHas('siswa.kelas', function ($q) {
                $q->where('id', request('kelas_id'));
            });
        }
        if (request('pegawai_id')) {
            $query->whereHas('tugas.mataPelajaran.guruPengampu', function ($q) {
                $q->where('id', request('pegawai_id'));
            });
        }

        $pengumpulanTugas = $query->get();

        $mataPelajaran = MataPelajaran::all();
        $kelas = Kelas::all();
        $guru = Pegawai::whereHas('user.roles', function ($q) {
            $q->where('name', 'guru');
        })->get();
        return view('master.rekap-nilai.index', [
            'title' => 'Rekap Nilai',
            'pengumpulanTugas' => $pengumpulanTugas,
            'mataPelajaran' => $mataPelajaran,
            'kelas' => $kelas,
            'guru' => $guru,
        ]);
    }

    public function indexSiswa()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        $roles = $user->roles->pluck('name')->toArray();
        $query = PengumpulanTugas::with(['siswa.kelas', 'tugas.mataPelajaran.guruPengampu']);

        if (!$siswa) {
            return redirect()->back()->with('error', 'Anda tidak terdaftar sebagai siswa.');
        }

        $query = PengumpulanTugas::whereHas('siswa', function ($q) use ($siswa) {
            $q->where('id', $siswa->id);
        })->with(['tugas.mataPelajaran.guruPengampu']);

        if (request('mata_pelajaran_id')) {
            $query->whereHas('tugas.mataPelajaran', function ($q) {
                $q->where('id', request('mata_pelajaran_id'));
            });
        }

        $pengumpulanTugas = $query->get();
        $mataPelajaran = MataPelajaran::all();

        return view('master.rekap-nilai.index-siswa', [
            'title' => 'Rekap Nilai Siswa',
            'pengumpulanTugas' => $pengumpulanTugas,
            'mataPelajaran' => $mataPelajaran,
        ]);
    }
}
