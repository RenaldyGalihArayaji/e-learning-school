<?php

namespace App\Http\Controllers\Master;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with('user')->get();
        return view('master.pegawai.index', ['title' => 'Pegawai'], compact('pegawai'));
    }

    public function create()
    {
        $role = Role::where('name', '!=', 'siswa')->get();
        return view('master.pegawai.create', ['title' => 'Pegawai'], compact('role'));
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nama_lengkap' => 'required:max:200',
            'nip' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable',
            'jabatan' => 'required',
            'status_pegawai' => 'required',
            'alamat' => 'nullable',
            'username' => 'required|min:3|max:100',
            'password' => 'required|min:8',
            'role' => 'required',
            'email' => 'nullable|email:dns|unique:users',
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi!',
            'nip.required' => 'NIP harus diisi!',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih!',
            'jabatan.required' => 'Jabatan harus diisi!',
            'status_pegawai.required' => 'Status pegawai harus dipilih!',
            'username.required' => 'Username harus diisi!',
            'username.min' => 'Username minimal 3 karakter!',
            'username.max' => 'Username maksimal 100 karakter!',
            'email.email' => 'Format email salah!',
            'email.unique' => 'Email sudah terdaftar!'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {
            $user = User::create([
                'username' => strtolower($request->username),
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
            ]);

            $user->syncRoles($request->role);

            Pegawai::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'nip' => $request->nip,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jabatan' => $request->jabatan,
                'status_pegawai' => $request->status_pegawai,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
            ]);

            Alert::success('Sukses', 'Data Berhasil ditambah!');
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil ditambah!'
            ]);
        }
    }

    public function edit(string $id)
    {
        $pegawai = Pegawai::with('user')->findOrFail($id);
        $roles = Role::where('name', '!=', 'siswa')->get();
        $userRoles = $pegawai->user->roles->pluck('id')->toArray();
        return view('master.pegawai.edit', ['title' => 'Pegawai'], compact('pegawai', 'userRoles', 'roles'));
    }


    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|max:200',
            'nip' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable',
            'jabatan' => 'required',
            'status_pegawai' => 'required',
            'alamat' => 'nullable',
            'username' => 'required|min:3|max:100',
            'email' => 'nullable|email:dns',
            'role' => 'required',
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi!',
            'nip.required' => 'NIP harus diisi!',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih!',
            'jabatan.required' => 'Jabatan harus diisi!',
            'status_pegawai.required' => 'Status pegawai harus dipilih!',
            'username.required' => 'Username harus diisi!',
            'username.min' => 'Username minimal 3 karakter!',
            'username.max' => 'Username maksimal 100 karakter!',
            'email.email' => 'Format email salah!',
            'email.unique' => 'Email sudah terdaftar!',
            'role.required' => 'Role harus dipilih!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ]);
        }

        $pegawai = Pegawai::findOrFail($id);
        $user = $pegawai->user;
        $user->username = strtolower($request->username);
        $user->email = strtolower($request->email);
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $user->syncRoles($request->role);

        $pegawai->nama_lengkap = $request->nama_lengkap;
        $pegawai->nip = $request->nip;
        $pegawai->jenis_kelamin = $request->jenis_kelamin;
        $pegawai->tempat_lahir = $request->tempat_lahir;
        $pegawai->tanggal_lahir = $request->tanggal_lahir;
        $pegawai->jabatan = $request->jabatan;
        $pegawai->status_pegawai = $request->status_pegawai;
        $pegawai->alamat = $request->alamat;
        $pegawai->no_telp = $request->no_telp;
        $pegawai->save();

        Alert::success('Sukses', 'Data Berhasil diupdate!');
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil diupdate!'
        ]);
    }

    public function destroy(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $user = $pegawai->user;

        if ($user) {
            $user->delete();
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index');
    }
}
