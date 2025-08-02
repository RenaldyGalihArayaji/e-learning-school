<?php

namespace App\Http\Controllers\Master;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{

    public function index()
    {
        $siswa = Siswa::with(['user','kelas'])->orderBy('created_at', 'desc')->get();
        return view('master.siswa.index',['title' => 'siswa'], compact('siswa'));
    }

    public function create()
    {
        $kelas = Kelas::with(['tahunAjaran' => function ($query) {
            $query->where('status', true);
        }])->get();
        $role = Role::all();
        return view('master.siswa.create', ['title' => 'siswa'], compact(['kelas', 'role']));
    }


    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'user_id' => 'nullable|exists:users,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'nama_lengkap' => 'required|max:200',
            'nisn' => 'nullable|string|max:20',
            'nis' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:500',
            'no_telp' => 'nullable|string|max:15',
            'angkatan' => 'nullable|string|max:10',
            'username' => 'required|min:3|max:100',
            'password' => 'required|min:8',
            'email' => 'nullable|email:dns|unique:users',
        ],[
            'nama_lengkap.required' => 'Nama lengkap harus diisi!',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih!',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid!',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid!',
            'alamat.max' => 'Alamat maksimal 500 karakter!',
            'no_telp.max' => 'Nomor telepon maksimal 15 karakter!',
            'angkatan.max' => 'Angkatan maksimal 10 karakter!',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid!',
            'user_id.exists' => 'User yang dipilih tidak valid!',
            'nisn.max' => 'NISN maksimal 20 karakter!',
            'nis.max' => 'NIS maksimal 20 karakter!',
            'tempat_lahir.max' => 'Tempat lahir maksimal 100 karakter!',
            'username.required' => 'Username harus diisi!',
            'username.min' => 'Username minimal 3 karakter!',
            'username.max' => 'Username maksimal 100 karakter!',
            'email.email' => 'Format email salah!',
            'email.unique' => 'Email sudah terdaftar!',
            'password.required' => 'Password harus diisi!',
            'password.min' => 'Password minimal 8 karakter!',
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

             $user->assignRole('siswa');

            Siswa::create([
                'user_id' => $user->id,
                'kelas_id' => $request->kelas_id,
                'nama_lengkap' => $request->nama_lengkap,
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'angkatan' => $request->angkatan,
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
        $siswa = Siswa::with(['user', 'kelas'])->findOrFail($id);
        $kelas = Kelas::with(['tahunAjaran' => function ($query) {
            $query->where('status', true);
        }])->get();
        $roles = Role::all();
        $userRoles = $siswa->user->roles->pluck('id')->toArray();
        return view('master.siswa.edit', ['title' => 'siswa'], compact(['siswa', 'kelas', 'roles', 'userRoles']));
    }

    public function update(Request $request, string $id)
    {
        $validasi = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'nama_lengkap' => 'required|max:200',
            'nisn' => 'nullable|string|max:20',
            'nis' => 'nullable|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:500',
            'no_telp' => 'nullable|string|max:15',
            'angkatan' => 'nullable|string|max:10',
            'username' => 'required|min:3|max:100',
            'email' => 'nullable|email:dns|unique:users,email,' . $request->user_id,
            'password' => 'nullable|min:8',
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi!',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih!',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid!',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid!',
            'alamat.max' => 'Alamat maksimal 500 karakter!',
            'no_telp.max' => 'Nomor telepon maksimal 15 karakter!',
            'angkatan.max' => 'Angkatan maksimal 10 karakter!',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid!',
            'user_id.exists' => 'User yang dipilih tidak valid!',
            'nisn.max' => 'NISN maksimal 20 karakter!',
            'nis.max' => 'NIS maksimal 20 karakter!',
            'tempat_lahir.max' => 'Tempat lahir maksimal 100 karakter!',
            'username.required' => 'Username harus diisi!',
            'username.min' => 'Username minimal 3 karakter!',
            'username.max' => 'Username maksimal 100 karakter!',
            'email.email' => 'Format email salah!',
            'email.unique' => 'Email sudah terdaftar!',
            'password.min' => 'Password minimal 8 karakter!',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validasi->messages()
            ]);
        } else {
            $siswa = Siswa::findOrFail($id);
            $user = $siswa->user;

            $user->username = strtolower($request->username);
            $user->email = strtolower($request->email);
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            $siswa->kelas_id = $request->kelas_id;
            $siswa->nama_lengkap = $request->nama_lengkap;
            $siswa->nisn = $request->nisn;
            $siswa->nis = $request->nis;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->tempat_lahir = $request->tempat_lahir;
            $siswa->tanggal_lahir = $request->tanggal_lahir;
            $siswa->angkatan = $request->angkatan;
            $siswa->alamat = $request->alamat;
            $siswa->no_telp = $request->no_telp;
            $siswa->save();

            Alert::success('Sukses', 'Data Berhasil diupdate!');
            return response()->json([
                'status' => 200,
                'message' => 'Data Berhasil diupdate!'
            ]);
        }
    }


    public function destroy(string $id)
    {
         $siswa = Siswa::findOrFail($id);
        $user = $siswa->user;

        if ($user) {
            $user->delete();
        }

        $siswa->delete();

        return redirect()->route('siswa.index');
    }
}
