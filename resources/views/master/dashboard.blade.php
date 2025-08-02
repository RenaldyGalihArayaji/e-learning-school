@extends('master.layouts.app')

@section('content')
    <div class="title">
        Dashboard
    </div>

    <div class="content-wrapper">
        <div class="row same-height">
            @can('view materi-pelajaran-siswa')
                <div class="col-md-3">
                    <div class="card border-0 h-100 py-3" style="border-radius: 15px;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h5 class="font-weight-bold text-uppercase text-secondary mb-1">Tugas Sudah</h5>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahTugasTerkumpul }}</div>
                                </div>
                                <div class="col-auto">
                                    <img src="{{ asset('template-admin/assets/image/tugas-sukses.gif') }}" alt=""
                                        width="60" height="60">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 h-100 py-3" style="border-radius: 15px;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h5 class="font-weight-bold text-uppercase text-secondary mb-1">Tugas Belum</h5>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahTugasBelumTerkumpul }}</div>
                                </div>
                                <div class="col-auto">
                                    <img src="{{ asset('template-admin/assets/image/tugas-gagal.gif') }}" alt=""
                                        width="60" height="60">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 h-100 py-3" style="border-radius: 15px;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h5 class="font-weight-bold text-uppercase text-secondary mb-1">Jumlah Mata Pelajaran</h5>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jmlMapel }}</div>
                                </div>
                                <div class="col-auto">
                                    <img src="{{ asset('template-admin/assets/image/mapel.gif') }}" alt=""
                                        width="60" height="60">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('view tugas')
                <div class="col-md-3">
                    <div class="card border-0 h-100 py-3" style="border-radius: 15px;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h5 class="font-weight-bold text-uppercase text-secondary mb-1">Jumlah Siswa</h5>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahSiswa }}</div>
                                </div>
                                <div class="col-auto">
                                    <img src="{{ asset('template-admin/assets/image/siswa.gif') }}" alt=""
                                        width="60" height="60">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $user = Auth::user();
                    $roles = $user->roles->pluck('name')->toArray();
                @endphp

                 @if (!in_array('guru', $roles))
                <div class="col-md-3">
                    <div class="card border-0 h-100 py-3" style="border-radius: 15px;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h5 class="font-weight-bold text-uppercase text-secondary mb-1">Jumlah Guru</h5>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jmlGuru }}</div>
                                </div>
                                <div class="col-auto">
                                    <img src="{{ asset('template-admin/assets/image/guru.gif') }}" alt="" width="60"
                                        height="60">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-md-3">
                    <div class="card border-0 h-100 py-3" style="border-radius: 15px;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h5 class="font-weight-bold text-uppercase text-secondary mb-1">Jumlah Kelas</h5>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jmlKelas }}</div>
                                </div>
                                <div class="col-auto">
                                    <img src="{{ asset('template-admin/assets/image/kelas.gif') }}" alt=""
                                        width="60" height="60">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 h-100 py-3" style="border-radius: 15px;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h5 class="font-weight-bold text-uppercase text-secondary mb-1">Jumlah Mata Pelajaran</h5>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jmlMapel }}</div>
                                </div>
                                <div class="col-auto">
                                    <img src="{{ asset('template-admin/assets/image/mapel.gif') }}" alt=""
                                        width="60" height="60">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan



            <div class="col-md-3">
                <div class="card border-0 h-100 py-3" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <h5 class="font-weight-bold text-uppercase text-secondary mb-1">Tahun Ajaran</h5>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $tahunAjaranAktif->nama_tahun_ajaran }}</div>
                            </div>
                            <div class="col-auto">
                                <img src="{{ asset('template-admin/assets/image/tahun.gif') }}" alt=""
                                    width="60" height="60">
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        @can('view materi-pelajaran-siswa')
            <div class="row">
                <div class="col-md-6 mt-4">
                    <div class="card border-0 h-100" style="border-radius: 15px;">
                        <div class="card-header bg-white py-3">
                            <h5 class="m-0 font-weight-bold text-success">Tugas Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="accordionTugas">
                                @forelse($tugas as $index => $item)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-{{ $index }}">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}"
                                                aria-expanded="false" aria-controls="collapse-{{ $index }}">
                                                {{ $item->mataPelajaran->nama_mata_pelajaran ?? '-' }} -
                                                {{ $item->judul ?? '-' }}
                                            </button>
                                        </h2>
                                        <div id="collapse-{{ $index }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading-{{ $index }}" data-bs-parent="#accordionTugas">
                                            <div class="accordion-body">
                                                <p class="mb-1"><strong>Deskripsi:</strong> {{ $item->deskripsi ?? '-' }}
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">Tenggat:
                                                        {{ \Carbon\Carbon::parse($item->batas_waktu)->translatedFormat('d F Y') }}</small>
                                                    @if (\Carbon\Carbon::parse($item->batas_waktu)->lt(\Carbon\Carbon::today()))
                                                        <span class="badge bg-danger text-white">Terlambat</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="accordion-item">
                                        <div class="accordion-body text-center text-muted">
                                            Tidak ada tugas terbaru
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection
