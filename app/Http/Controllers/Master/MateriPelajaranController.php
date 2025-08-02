<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use GuzzleHttp\Promise\Create;
use App\Models\MateriPelajaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class MateriPelajaranController extends Controller
{
    public function index($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $materiPelajaran = MateriPelajaran::where('mata_pelajaran_id', $id)->orderBy('created_at', 'desc')->get();
        return view('master.materi-pelajaran.index',['title' => 'Materi Pelajaran'],compact(['materiPelajaran', 'mataPelajaran']));
    }

    public function create($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        return view('master.materi-pelajaran.create', ['title' => 'Tambah Materi Pelajaran'], compact('mataPelajaran'));
    }

    public function store(Request $request, $id)
    {

        $validasi = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'url_file' => 'nullable|url',
            'type_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,mp4|max:3048',
            'tanggal_upload' => 'nullable|date',
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
            $fileName = 'materi_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('materi', $file, $fileName);
        }

       MateriPelajaran::create([
            'mata_pelajaran_id' => $id,
            'pegawai_id' => Auth::user()->pegawai->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'url_file' => $request->url_file,
            'type_file' => $fileName,
            'tanggal_upload' => now(),
        ]);

       Alert::success('Sukses', 'Data Berhasil diupdate!');
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil diupdate!'
        ]);
    }

    public function show($id)
    {
        $materi = MateriPelajaran::findOrFail($id);
        return view('master.materi-pelajaran.show', ['title' => 'Detail Materi Pelajaran'], compact('materi'));
    }

    public function edit($id)
    {
        $materi = MateriPelajaran::findOrFail($id);
        return view('master.materi-pelajaran.edit', ['title' => 'Edit Materi Pelajaran'], compact('materi'));
    }

    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'url_file' => 'nullable|url',
            'type_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,mp4|max:3048',
            'tanggal_upload' => 'nullable|date',
        ],[
            'judul.required' => 'Judul materi harus diisi.',
            'judul.string' => 'Judul materi harus berupa teks.',
            'judul.max' => 'Judul materi tidak boleh lebih dari 255 karakter.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'url_file.url' => 'URL file harus valid.',
            'type_file.file' => 'File harus berupa file yang valid.',
            'type_file.mimes' => 'File harus berupa salah satu dari: pdf, doc, docx, ppt, pptx, jpg, jpeg, png, mp4.',
            'type_file.max' => 'Ukuran file tidak boleh lebih dari 3 MB.',
            'tanggal_upload.date' => 'Tanggal upload harus berupa tanggal yang valid.'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->errors()
            ]);
        }

        $materi = MateriPelajaran::findOrFail($id);
        $fileName = $materi->type_file;

        if ($request->hasFile('type_file')) {
            if ($materi->type_file) {
                Storage::delete('public/materi/' . $materi->type_file);
            }
            $file = $request->file('type_file');
            $fileName = 'materi_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('materi', $file, $fileName);
        }

        $materi->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'url_file' => $request->url_file,
            'type_file' => $fileName,
            'tanggal_upload' => now(),
        ]);

        Alert::success('Sukses', 'Data Berhasil diupdate!');
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil diupdate!'
        ]);
    }


    public function destroy($id)
    {
        $materi = MateriPelajaran::findOrFail($id);
        if ($materi->type_file) {
            Storage::delete('public/materi/' . $materi->type_file);
        }
        $materi->delete();

        return redirect()->back();
    }
}
