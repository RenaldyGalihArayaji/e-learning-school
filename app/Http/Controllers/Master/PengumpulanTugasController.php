<?php

namespace App\Http\Controllers\Master;

use App\Models\Tugas;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use GuzzleHttp\Promise\Create;
use App\Models\PengumpulanTugas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class PengumpulanTugasController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->siswa) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini atau data siswa tidak ditemukan.');
        }
        $kelasId = $user->siswa->kelas_id;
        if (!$kelasId) {
            return redirect()->back()->with('error', 'Kelas Anda tidak ditemukan.');
        }
        $mataPelajaranIds = MataPelajaran::where('kelas_id', $kelasId)->pluck('id');
        $tugas = Tugas::whereIn('mata_pelajaran_id', $mataPelajaranIds)
            ->with(['mataPelajaran', 'pegawai','pengumpulanTugas'])
            ->get();
        return view('master.tugas-siswa.index', ['title' => 'Pengumpulan Tugas'], compact('tugas'));
    }

    public function create($id)
    {
        $tugas = Tugas::with('pengumpulanTugas')->findOrFail($id);
        return view('master.tugas-siswa.create', [
            'title' => 'Tambah Pengumpulan Tugas',
            'tugas' => $tugas
        ]);
    }

    public function store(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'jawaban' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'jawaban.required' => 'Jawaban tidak boleh kosong.',
            'jawaban.string' => 'Jawaban harus berupa teks.',
            'file.file' => 'File harus berupa file.',
            'file.mimes' => 'File harus berupa file dengan format: pdf, jpg, jpeg, png.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->errors()
            ]);
        }

        $tugas = Tugas::findOrFail($id);
        $user = Auth::user();
        if (!$user || !$user->siswa) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini atau data siswa tidak ditemukan.');
        }

         $fileName = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $tugas->judul . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('file_jawaban', $file, $fileName);
        }


        PengumpulanTugas::create([
            'tugas_id' => $tugas->id,
            'siswa_id' => $user->siswa->id,
            'jawaban' => $request->jawaban,
            'tanggal_pengumpulan' => now(),
            'status' => true,
            'file' => $fileName,
        ]);


        Alert::success('Sukses', 'Data Berhasil dikirim!');
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil dikirim!'
        ]);
    }
}
