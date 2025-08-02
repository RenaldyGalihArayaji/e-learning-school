<?php

namespace App\Http\Controllers\Master;

use App\Models\Tugas;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use App\Models\PengumpulanTugas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class TugasController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name')->toArray();
        if (in_array('super-admin', $roles)) {
            $tugas = Tugas::with(['pegawai', 'mataPelajaran'])->orderBy('created_at', 'desc')->get();
        } else if (in_array('guru', $roles)) {
            $tugas = Tugas::with(['pegawai', 'mataPelajaran'])
                ->where('pegawai_id', $user->pegawai->id)
                ->orderBy('created_at', 'desc')->get();
        } else {
            $tugas = collect();
        }
        return view('master.tugas.index', ['title' => 'Tugas'], compact('tugas'));
    }


    public function create()
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name')->toArray();
        if (in_array('super-admin', $roles)) {
            $mataPelajaran = MataPelajaran::with(['kelas', 'guruPengampu', 'tahunAjaran'])->get();
        } else if (in_array('guru', $roles)) {
            $mataPelajaran = MataPelajaran::with(['kelas', 'guruPengampu', 'tahunAjaran'])
                ->where('guru_pengampu_id', $user->pegawai->id)
                ->get();
        } else {
            $mataPelajaran = collect();
        }
        return view('master.tugas.create', ['title' => 'Tambah Tugas'], compact('mataPelajaran'));
    }


    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'nilai_maksimal' => 'nullable|numeric',
            'batas_waktu' => 'required|date',
            'url_file' => 'nullable|url',
            'type_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ], [
            'mata_pelajaran_id.required' => 'Mata Pelajaran harus dipilih.',
            'judul.required' => 'Judul tugas harus diisi.',
            'nilai_maksimal.numeric' => 'Nilai maksimal harus berupa angka.',
            'batas_waktu.date' => 'Batas waktu harus berupa tanggal yang valid.',
            'batas_waktu.required' => 'Batas waktu harus diisi.',
            'url_file.url' => 'URL file harus berupa URL yang valid.',
            'type_file.file' => 'File harus berupa dokumen.',
            'type_file.mimes' => 'File harus berupa dokumen dengan format pdf, doc, docx, jpg, jpeg, png.',
            'type_file.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->errors()
            ]);
        }

        $fileName = null;
        if ($request->hasFile('type_file')) {
            $file = $request->file('type_file');
            $fileName = 'tugas_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('file_tugas', $file, $fileName);
        }

        Tugas::create([
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'pegawai_id' => Auth::user()->pegawai->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'nilai_maksimal' => $request->nilai_maksimal,
            'batas_waktu' => $request->batas_waktu,
            'type_file' => $fileName,
            'url_file' => $request->url_file,
            'tanggal_upload' => now(),
        ]);

        Alert::success('Sukses', 'Tugas berhasil ditambahkan!');
        return response()->json([
            'status' => 200,
            'message' => 'Tugas berhasil ditambahkan!'
        ]);
    }

    public function show(string $id)
    {
        $tugas = Tugas::with(['mataPelajaran', 'pegawai'])->findOrFail($id);
        return view('master.tugas.show', ['title' => 'Detail Tugas'], compact('tugas'));
    }

    public function edit(string $id)
    {
        $tugas = Tugas::findOrFail($id);
        $user = Auth::user();
        $roles = $user->roles->pluck('name')->toArray();
        if (in_array('super-admin', $roles)) {
            $mataPelajaran = MataPelajaran::with(['kelas', 'guruPengampu', 'tahunAjaran'])->get();
        } else if (in_array('guru', $roles)) {
            $mataPelajaran = MataPelajaran::with(['kelas', 'guruPengampu', 'tahunAjaran'])
                ->where('guru_pengampu_id', $user->pegawai->id)
                ->get();
        } else {
            $mataPelajaran = collect();
        }
        return view('master.tugas.edit', ['title' => 'Edit Tugas'], compact(['tugas', 'mataPelajaran']));
    }

    public function update(Request $request, string $id)
    {
        $validasi = Validator::make($request->all(), [
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'nilai_maksimal' => 'nullable|numeric',
            'batas_waktu' => 'required|date',
            'url_file' => 'nullable|url',
            'type_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->errors()
            ]);
        }

        $tugas = Tugas::findOrFail($id);
        $fileName = $tugas->type_file;

        if ($request->hasFile('type_file')) {
            if ($fileName) {
                Storage::disk('public')->delete('file_tugas/' . $fileName);
            }
            $file = $request->file('type_file');
            $fileName = 'tugas_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('file_tugas', $file, $fileName);
        }

        $tugas->update([
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'nilai_maksimal' => $request->nilai_maksimal,
            'batas_waktu' => $request->batas_waktu,
            'type_file' => $fileName,
            'url_file' => $request->url_file,
        ]);

        Alert::success('Sukses', 'Tugas berhasil diperbarui!');
        return response()->json([
            'status' => 200,
            'message' => 'Tugas berhasil diperbarui!'
        ]);
    }

    public function destroy(string $id)
    {
        $tugas = Tugas::findOrFail($id);
        if ($tugas->type_file) {
            Storage::disk('public')->delete('file_tugas/' . $tugas->type_file);
        }
        $tugas->delete();

        return redirect()->back();
    }

    public function indexSiswa($id)
    {
        $tugas = Tugas::with(['mataPelajaran', 'pegawai', 'pengumpulanTugas'])
            ->findOrFail($id);
        $siswa = $tugas->pengumpulanTugas->pluck('siswa')->unique('id');
        return view('master.tugas.siswa', ['title' => 'Siswa Mengerjakan Tugas'], compact('tugas', 'siswa'));
    }

    public function editSiswa($tugas_id, $pengumpulan_id)
    {
        $pengumpulan = PengumpulanTugas::with('siswa')->findOrFail($pengumpulan_id);
        return view('master.tugas.edit-siswa', compact('pengumpulan'));
    }

    public function updateSiswa(Request $request, $tugas_id, $pengumpulan_id)
    {
        $validasi = Validator::make($request->all(), [
            'komentar_guru' => 'nullable|string|max:500',
            'nilai' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->errors()
            ]);
        }

        $pengumpulan = PengumpulanTugas::findOrFail($pengumpulan_id);
        $pengumpulan->update([
            'komentar_guru' => $request->komentar_guru,
            'nilai' => $request->nilai,
        ]);

        Alert::success('Sukses', 'Data siswa berhasil diperbarui!');
        return response()->json([
            'status' => 200,
            'message' => 'Data siswa berhasil diperbarui!'
        ]);
    }
}
