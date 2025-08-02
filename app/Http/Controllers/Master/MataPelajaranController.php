<?php

namespace App\Http\Controllers\Master;

use App\Models\Kelas;
use App\Models\Pegawai;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name')->toArray();
        if (in_array('super-admin', $roles)) {
            $mataPelajaran = MataPelajaran::with(['kelas', 'guruPengampu', 'tahunAjaran'])->orderBy('created_at', 'desc')->get();
        } else if (in_array('guru', $roles)) {
            $mataPelajaran = MataPelajaran::with(['kelas', 'guruPengampu', 'tahunAjaran'])
                ->where('guru_pengampu_id', $user->pegawai->id)
                ->orderBy('created_at', 'desc')->get();
        } else if(in_array('siswa', $roles)) {
            $mataPelajaran = MataPelajaran::with(['kelas', 'guruPengampu', 'tahunAjaran'])
                ->whereHas('kelas.siswas', function($query) use ($user) {
                    $query->where('id', $user->siswa->id);
                })->orderBy('created_at', 'desc')->get();
        }else {
            $mataPelajaran = collect();
        }
        return view('master.mata-pelajaran.index', ['title' => 'Mata Pelajaran'], compact('mataPelajaran'));
    }


    public function create()
    {
        $kelas = Kelas::all();
        $guruPengampu = Pegawai::whereHas('user.roles', function($q) {
            $q->where('name', 'guru');
        })->get();
        $tahunAjaran = TahunAjaran::where('status', true)->first();
        return view('master.mata-pelajaran.create', compact('kelas', 'guruPengampu', 'tahunAjaran'));
    }


    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'kelas_id' => 'required|exists:kelas,id',
            'guru_pengampu_id' => 'required|exists:pegawai,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'nama_mata_pelajaran' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ],[
            'kelas_id.required' => 'Kelas harus dipilih.',
            'guru_pengampu_id.required' => 'Guru pengampu harus dipilih.',
            'tahun_ajaran_id.required' => 'Tahun ajaran harus dipilih.',
            'nama_mata_pelajaran.required' => 'Nama mata pelajaran harus diisi.',
        ]);

        if ($validasi->fails()) {
             return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {
            MataPelajaran::create([
                'kelas_id' => $request->kelas_id,
                'guru_pengampu_id' => $request->guru_pengampu_id,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
                'nama_mata_pelajaran' => $request->nama_mata_pelajaran,
                'deskripsi' => $request->deskripsi,
            ]);

            Alert::success('Berhasil', 'Mata pelajaran berhasil ditambahkan.');

            return response()->json([
                'status' => 200,
                'message' => 'Mata pelajaran berhasil ditambahkan.'
            ]);
        }

    }

    public function edit(string $id)
    {
        $mataPelajaran = MataPelajaran::with('tahunAjaran')->findOrFail($id);
        $kelas = Kelas::all();
        $guruPengampu = Pegawai::whereHas('user.roles', function($q) {
            $q->where('name', 'guru');
        })->get();
        $tahunAjaran = TahunAjaran::where('status', true)->first();
        return view('master.mata-pelajaran.edit', compact('mataPelajaran', 'kelas', 'guruPengampu', 'tahunAjaran'));
    }


    public function update(Request $request, string $id)
    {
       $validasi = Validator::make($request->all(), [
            'kelas_id' => 'required|exists:kelas,id',
            'guru_pengampu_id' => 'required|exists:pegawai,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'nama_mata_pelajaran' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ],[
            'kelas_id.required' => 'Kelas harus dipilih.',
            'guru_pengampu_id.required' => 'Guru pengampu harus dipilih.',
            'tahun_ajaran_id.required' => 'Tahun ajaran harus dipilih.',
            'nama_mata_pelajaran.required' => 'Nama mata pelajaran harus diisi.',
        ]);

        if ($validasi->fails()) {
             return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {
            $mataPelajaran = MataPelajaran::findOrFail($id);
            $mataPelajaran->update([
                'kelas_id' => $request->kelas_id,
                'guru_pengampu_id' => $request->guru_pengampu_id,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
                'nama_mata_pelajaran' => $request->nama_mata_pelajaran,
                'deskripsi' => $request->deskripsi,
            ]);

            Alert::success('Berhasil', 'Mata pelajaran berhasil diperbarui.');
            return response()->json([
                'status' => 200,
                'message' => 'Mata pelajaran berhasil diperbarui.'
            ]);
        }
    }


    public function destroy(string $id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->delete();

        return redirect()->route('mata-pelajaran.index');
    }

    // Untuk Menampilkan Siswa yang terdaftar pada mata pelajaran
    public function indexSiswa($id)
    {
        // Eager load kelas dan siswas sekaligus
        $mataPelajaran = MataPelajaran::with(['kelas.siswas'])->findOrFail($id);
        $siswa = $mataPelajaran->kelas ? $mataPelajaran->kelas->siswas : collect();

        return view('master.mata-pelajaran.siswa', [
            'title' => 'Siswa Mata Pelajaran',
            'mataPelajaran' => $mataPelajaran,
            'siswa' => $siswa
        ]);
    }
}
