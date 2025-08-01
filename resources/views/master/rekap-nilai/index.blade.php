@extends('master.layouts.app')

@section('content')
    <div class="title">
        <h1 class="h3 mb-0 text-gray-800">Rekap Nilai</h1>
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Rekap Nilai</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            {{-- Filter Section --}}
                            <form action="{{ route('rekap-nilai.index') }}" method="GET">
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <a href="{{ route('rekap-nilai.export', array_filter([
                                        'mata_pelajaran_id' => request('mata_pelajaran_id'),
                                        'kelas_id' => request('kelas_id'),
                                        'pegawai_id' => request('pegawai_id')
                                    ])) }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-file-earmark-pdf me-2"></i>Export PDF
                                    </a>
                                    @php
                                        $user = Auth::user();
                                        $roles = $user->roles->pluck('name')->toArray();
                                    @endphp
                                    @if (!in_array('guru', $roles))
                                        <select name="mata_pelajaran_id" id="mata_pelajaran_id"
                                            class="form-select form-select-sm" style="max-width: 140px;">
                                            <option value="">Mata Pelajaran</option>
                                            @foreach ($mataPelajaran as $mp)
                                                <option value="{{ $mp->id }}"
                                                    {{ request('mata_pelajaran_id') == $mp->id ? 'selected' : '' }}>
                                                    {{ ucwords($mp->nama_mata_pelajaran) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select name="kelas_id" id="kelas_id" class="form-select form-select-sm"
                                            style="max-width: 110px;">
                                            <option value="">Kelas</option>
                                            @foreach ($kelas as $k)
                                                <option value="{{ $k->id }}"
                                                    {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                                    {{ $k->nama_kelas }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select name="pegawai_id" id="pegawai_id" class="form-select form-select-sm"
                                            style="max-width: 140px;">
                                            <option value="">Guru</option>
                                            @foreach ($guru as $g)
                                                <option value="{{ $g->id }}"
                                                    {{ request('pegawai_id') == $g->id ? 'selected' : '' }}>
                                                    {{ ucwords($g->nama_lengkap) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select name="mata_pelajaran_id" id="mata_pelajaran_id"
                                            class="form-select form-select-sm" style="max-width: 140px;">
                                            <option value="">Mata Pelajaran</option>
                                            @foreach ($mataPelajaran as $mp)
                                                <option value="{{ $mp->id }}"
                                                    {{ request('mata_pelajaran_id') == $mp->id ? 'selected' : '' }}>
                                                    {{ ucwords($mp->nama_mata_pelajaran) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select name="kelas_id" id="kelas_id" class="form-select form-select-sm"
                                            style="max-width: 110px;">
                                            <option value="">Kelas</option>
                                            @foreach ($kelas as $k)
                                                <option value="{{ $k->id }}"
                                                    {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                                    {{ $k->nama_kelas }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-filter me-2"></i>Filter
                                    </button>
                                    <a href="{{ route('rekap-nilai.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Reset
                                    </a>
                                </div>
                            </form>
                        </div>

                        <table id="example2" class="table dt-responsive display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Tugas</th>
                                    <th>Kelas</th>
                                    <th>Guru</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengumpulanTugas as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucwords($item->siswa->nama_lengkap) }}</td>
                                        <td>{{ ucwords($item->tugas->mataPelajaran->nama_mata_pelajaran) }}</td>
                                        <td>{{ ucwords($item->tugas->judul) }}</td>
                                        <td>{{ $item->siswa->kelas->nama_kelas }}</td>
                                        <td>{{ ucwords($item->tugas->mataPelajaran->guruPengampu->nama_lengkap) }}</td>
                                        <td>{{ $item->nilai }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('template-admin/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template-admin/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('template-admin/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('template-admin/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}">
    </script>
    <script src="{{ asset('template-admin//assets/js/pages/datatables.min.js') }}"></script>
    {{-- sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        DataTable.init()
    </script>
@endpush
