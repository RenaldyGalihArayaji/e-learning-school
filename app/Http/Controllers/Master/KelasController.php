<?php

namespace App\Http\Controllers\Master;

use App\Models\Kelas;
use App\Models\Pegawai;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{

    public function index()
    {
        $kelas = Kelas::with(['pegawai','tahunAjaran'])->orderBy('created_at', 'desc')->get();

        return view('master.kelas.index', ['title' => 'Kelas'], compact('kelas'));
    }

    public function create()
    {
        $pegawai = Pegawai::whereHas('user.roles', function($q) {
            $q->where('name', 'guru');
        })->get();
        $tahunAjaran = TahunAjaran::where('status', true)->first();
        return view('master.kelas.create', ['title' => 'Tambah Kelas'], compact('pegawai', 'tahunAjaran'));
    }


    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'pegawai_id' => 'nullable|exists:pegawai,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'nama_kelas' => 'required|string|max:255',
        ],[
            'pegawai_id.exists' => 'Pegawai tidak ditemukan.',
            'tahun_ajaran_id.required' => 'Tahun ajaran harus dipilih.',
            'tahun_ajaran_id.exists' => 'Tahun ajaran tidak ditemukan.',
            'nama_kelas.required' => 'Nama kelas harus diisi.',
            'nama_kelas.string' => 'Nama kelas harus berupa teks.',
            'nama_kelas.max' => 'Nama kelas maksimal 255 karakter.',
        ]);

        if ($validasi->fails()) {
             return response()->json([
                'status' => 400,
                'errors' => $validasi->errors(),
            ]);
        } else {
            Kelas::create([
                'pegawai_id' => $request->pegawai_id,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
                'nama_kelas' => $request->nama_kelas,
            ]);

            Alert::success('Berhasil', 'Kelas berhasil ditambahkan');
            return response()->json(['status' => 200, 'message' => 'Kelas berhasil ditambahkan']);
        }

    }


    public function edit(string $id)
    {
        $kelas = Kelas::with('tahunAjaran')->findOrFail($id);
        $pegawai = Pegawai::whereHas('user.roles', function($q) {
            $q->where('name', 'guru');
        })->get();
        $tahunAjaran = TahunAjaran::where('status', true)->first();

        return view('master.kelas.edit', ['title' => 'Edit Kelas'], compact('kelas', 'pegawai', 'tahunAjaran'));
    }


    public function update(Request $request, string $id)
    {
        $validasi = Validator::make($request->all(),[
            'pegawai_id' => 'nullable|exists:pegawai,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'nama_kelas' => 'required|string|max:255',
        ],[
            'pegawai_id.exists' => 'Pegawai tidak ditemukan.',
            'tahun_ajaran_id.required' => 'Tahun ajaran harus dipilih.',
            'tahun_ajaran_id.exists' => 'Tahun ajaran tidak ditemukan.',
            'nama_kelas.required' => 'Nama kelas harus diisi.',
            'nama_kelas.string' => 'Nama kelas harus berupa teks.',
            'nama_kelas.max' => 'Nama kelas maksimal 255 karakter.',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->errors(),
            ]);
        } else {
            $kelas = Kelas::findOrFail($id);
            $kelas->update([
                'pegawai_id' => $request->pegawai_id,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
                'nama_kelas' => $request->nama_kelas,
            ]);

            Alert::success('Berhasil', 'Kelas berhasil diperbarui');
            return response()->json(['status' => 200, 'message' => 'Kelas berhasil diperbarui']);
        }
    }


    public function destroy(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index');
    }
}
