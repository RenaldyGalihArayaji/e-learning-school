<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Master\KelasController;
use App\Http\Controllers\Master\SiswaController;
use App\Http\Controllers\Master\TugasController;
use App\Http\Controllers\Master\PegawaiController;
use App\Http\Controllers\Master\DashboardController;
use App\Http\Controllers\Master\TahunAjaranController;
use App\Http\Controllers\Master\MataPelajaranController;
use App\Http\Controllers\Master\MateriPelajaranController;
use App\Http\Controllers\Master\PengumpulanTugasController;
use App\Http\Controllers\Master\RekapNilaiController;

Route::middleware('guest')->group(function () {
    Route::get('login',[AuthController::class, 'login'])->name('login');
    Route::post('login',[AuthController::class, 'prosesLogin']);
});

Route::middleware('auth')->group(function () {
    Route::get('logout',[AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard',[DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('master')->group(function () {
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('kelas', KelasController::class);
        Route::resource('siswa', SiswaController::class);
        Route::resource('tahun-ajaran', TahunAjaranController::class);
    });

    Route::resource('mata-pelajaran',MataPelajaranController::class);
    Route::get('mata-pelajaran-siswa/{id}', [MataPelajaranController::class, 'indexSiswa'])->name('mata-pelajaran-siswa.index');
    Route::get('materi-pelajaran/{id}', [MateriPelajaranController::class, 'index'])->name('materi-pelajaran.index');
    Route::get('materi-pelajaran/create/{id}', [MateriPelajaranController::class, 'create'])->name('materi-pelajaran.create');
    Route::post('materi-pelajaran/store/{id}', [MateriPelajaranController::class, 'store'])->name('materi-pelajaran.store');
    Route::get('materi-pelajaran/edit/{id}', [MateriPelajaranController::class, 'edit'])->name('materi-pelajaran.edit');
    Route::put('materi-pelajaran/update/{id}', [MateriPelajaranController::class, 'update'])->name('materi-pelajaran.update');
    Route::delete('materi-pelajaran/destroy/{id}', [MateriPelajaranController::class, 'destroy'])->name('materi-pelajaran.destroy');
    Route::get('materi-pelajaran/show/{id}', [MateriPelajaranController::class, 'show'])->name('materi-pelajaran.show');

    Route::resource('tugas', TugasController::class);
    Route::get('tugas/{id}/siswa', [TugasController::class, 'indexSiswa'])->name('tugas.siswa');
    Route::get('tugas/{tugas_id}/siswa/{pengumpulan_id}/edit', [TugasController::class, 'editSiswa'])->name('tugas.siswa.edit');
    Route::put('tugas/{tugas_id}/siswa/{pengumpulan_id}/update', [TugasController::class, 'updateSiswa'])->name('tugas.siswa.update');

    Route::get('pengumpulan-tugas', [PengumpulanTugasController::class, 'index'])->name('pengumpulan-tugas.index');
    Route::get('pengumpulan-tugas/create/{id}', [PengumpulanTugasController::class, 'create'])->name('pengumpulan-tugas.create');
    Route::post('pengumpulan-tugas/store/{id}', [PengumpulanTugasController::class, 'store'])->name('pengumpulan-tugas.store');

    Route::get('rekap-nilai',[RekapNilaiController::class, 'index'])->name('rekap-nilai.index');
    Route::get('rekap-nilai-siswa',[RekapNilaiController::class, 'indexSiswa'])->name('rekap-nilai-siswa.index');
    Route::get('rekap-nilai/export', [RekapNilaiController::class, 'export'])->name('rekap-nilai.export');
    Route::get('rekap-nilai/export-siswa', [RekapNilaiController::class, 'exportSiswa'])->name('rekap-nilai.exportSiswa');
});

