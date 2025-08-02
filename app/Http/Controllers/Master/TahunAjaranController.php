<?php

namespace App\Http\Controllers\Master;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class TahunAjaranController extends Controller
{

    public function index()
    {
        $tahunAjaran = TahunAjaran::orderBy('status', 'desc')->orderBy('created_at', 'desc')->get();
        return view('master.tahun_ajaran.index', ['title' => 'Tahun Ajaran'], compact('tahunAjaran'));
    }

    public function create()
    {
        return view('master.tahun_ajaran.create', ['title' => 'Tambah Tahun Ajaran']);
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nama_tahun_ajaran' => 'required|string|max:255',
            'status' => 'required|boolean',
        ], [
            'nama_tahun_ajaran.required' => 'Nama Tahun Ajaran harus diisi',
            'status.required' => 'Status harus dipilih',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->errors(),
            ]);
        } else {
            // Jika status true, set semua status lain menjadi false
            if ($request->status == true || $request->status == 1 || $request->status === '1') {
                TahunAjaran::where('status', true)->update(['status' => false]);
            }
            TahunAjaran::create([
                'nama_tahun_ajaran' => $request->nama_tahun_ajaran,
                'status' => $request->status,
            ]);

            Alert::success('Berhasil', 'Tahun Ajaran berhasil ditambahkan');
            return response()->json(['status' => 200, 'message' => 'Tahun Ajaran berhasil ditambahkan']);
        }
    }

    public function edit(string $id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        return view('master.tahun_ajaran.edit', ['title' => 'Edit Tahun Ajaran', 'tahunAjaran' => $tahunAjaran]);
    }

    public function update(Request $request, string $id)
    {
        $validasi = Validator::make($request->all(), [
            'nama_tahun_ajaran' => 'required|string|max:255',
            'status' => 'required|boolean',
        ], [
            'nama_tahun_ajaran.required' => 'Nama Tahun Ajaran harus diisi',
            'status.required' => 'Status harus dipilih',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->errors(),
            ]);
        } else {
            $tahunAjaran = TahunAjaran::findOrFail($id);
            // Jika status true, set semua status lain menjadi false
            if ($request->status == true || $request->status == 1 || $request->status === '1') {
                TahunAjaran::where('id', '!=', $id)->where('status', true)->update(['status' => false]);
            }
            $tahunAjaran->update([
                'nama_tahun_ajaran' => $request->nama_tahun_ajaran,
                'status' => $request->status,
            ]);

            Alert::success('Berhasil', 'Tahun Ajaran berhasil diperbarui');
            return response()->json(['status' => 200, 'message' => 'Tahun Ajaran berhasil diperbarui']);
        }
    }


    public function destroy(string $id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->delete();
        return redirect()->route('tahun-ajaran.index');
    }
}
