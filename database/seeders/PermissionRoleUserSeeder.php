<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionRoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tambah Data Permission
        Permission::create(['name' => 'view pengumpulan-tugas']);
        Permission::create(['name' => 'view tugas']);
        Permission::create(['name' => 'view mata-pelajaran']);
        Permission::create(['name' => 'view materi-pelajaran']);
        Permission::create(['name' => 'view tahun-ajaran']);
        Permission::create(['name' => 'view siswa']);
        Permission::create(['name' => 'view pegawai']);
        Permission::create(['name' => 'view kelas']);
        Permission::create(['name' => 'view rekap-nilai']);
        Permission::create(['name' => 'view rekap-nilai-siswa']);

        // Tambah Data Role
        Role::create(["name" => "super-admin"]);
        Role::create(["name" => "guru"]);
        Role::create(["name" => "siswa"]);
        $roleSuperAdmin = Role::findByName('super-admin');
        $roleGuru = Role::findByName('guru');
        $roleSiswa = Role::findByName('siswa');

        $roleSuperAdmin->givePermissionTo('view tugas');
        $roleSuperAdmin->givePermissionTo('view mata-pelajaran');
        $roleSuperAdmin->givePermissionTo('view tahun-ajaran');
        $roleSuperAdmin->givePermissionTo('view siswa');
        $roleSuperAdmin->givePermissionTo('view pegawai');
        $roleSuperAdmin->givePermissionTo('view kelas');
        $roleSuperAdmin->givePermissionTo('view rekap-nilai');

        $roleGuru->givePermissionTo('view tugas');
        $roleGuru->givePermissionTo('view mata-pelajaran');
        $roleGuru->givePermissionTo('view rekap-nilai');

        $roleSiswa->givePermissionTo('view pengumpulan-tugas');
        $roleSiswa->givePermissionTo('view rekap-nilai-siswa');

        // Tambah User SuperAdmin
        $userSuperadmin = User::create([
            'username' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $userSuperadmin->assignRole($roleSuperAdmin);

        // Tambah User Pegawai
        Pegawai::create([
            'user_id' => $userSuperadmin->id,
            'nama_lengkap' => 'Super Admin',
            'nip' => '1234567890',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Super Admin No. 1',
            'no_telp' => '081234567890'
        ]);
    }
}
