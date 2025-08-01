@extends('master.layouts.app')

@section('content')
    <div class="title">
        <h1 class="h3 mb-0 text-gray-800">Mata Pelajaran | <span
                class="text-secondary fs-5">{{ ucwords($mataPelajaran->nama_mata_pelajaran) }} | {{ ucwords($mataPelajaran->kelas->nama_kelas) }}</span></h1>
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Siswa</h4>
                    </div>
                    <div class="card-body">
                          <div class="d-flex justify-content-between align-items-center">
                            <div></div>
                            <div>
                                <a href="{{ route('mata-pelajaran.index') }}"
                                    class="btn mb-3 icon-left btn-secondary btn-sm "><i
                                        class="bi bi-arrow-left-circle me-2"></i>Kembali</a>
                            </div>
                        </div>
                         <table id="example2" class="table dt-responsive display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Angkatan</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucwords($item->nama_lengkap) }}</td>
                                        <td>
                                            @if ($item->jenis_kelamin == 'L')
                                                <span>Laki-laki</span>
                                            @else
                                                <span>Perempuan</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->angkatan }}</td>
                                        <td>{{ $item->kelas->nama_kelas }}</td>
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
    <!-- start - This is for export functionality only -->
    <script>
        DataTable.init()
    </script>
@endpush
