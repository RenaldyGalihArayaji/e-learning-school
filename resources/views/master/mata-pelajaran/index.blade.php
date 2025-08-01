@extends('master.layouts.app')

@section('content')
    <div class="title">
        <h1 class="h3 mb-0 text-gray-800">Mata Pelajaran</h1>
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Mata Pelajaran</h4>
                    </div>
                    <div class="card-body">
                        @if (
                            (Auth::check() && Auth::user()->can('view pegawai')) ||
                                Auth::user()->can('view tahun-ajaran') ||
                                Auth::user()->can('view kelas') ||
                                Auth::user()->can('view siswa'))
                            <button class="btn mb-3 icon-left btn-primary btn-sm" onclick="create()"><i
                                    class="ti-plus"></i>Tambah Data</button>
                        @endif
                        <table id="example2" class="table dt-responsive display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Guru Pengampu</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Jumlah Siswa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mataPelajaran as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucwords($item->nama_mata_pelajaran) }}</td>
                                        <td>{{ $item->kelas->nama_kelas }}</td>
                                        <td>{{ ucwords($item->guruPengampu->nama_lengkap) }}</td>
                                        <td>{{ ucwords($item->tahunAjaran->nama_tahun_ajaran) }}</td>
                                        <td>{{ $item->kelas->siswas->count() }}</td>
                                        <td>
                                            <a href="{{ route('mata-pelajaran-siswa.index', $item->id) }}"
                                                class="btn btn-outline-primary btn-sm my-1">Lihat Siswa</a>
                                            <a href="{{ route('materi-pelajaran.index', $item->id) }}"
                                                class="btn btn-outline-warning btn-sm my-1">Lihat Materi</a>
                                            @if (
                                                (Auth::check() && Auth::user()->can('view pegawai')) ||
                                                    Auth::user()->can('view tahun-ajaran') ||
                                                    Auth::user()->can('view kelas') ||
                                                    Auth::user()->can('view siswa'))
                                                <button class="btn btn-outline-success btn-sm"
                                                    onclick="edit({{ $item->id }})"><i
                                                        class="ti-pencil-alt"></i></button>
                                                <form action="{{ route('mata-pelajaran.destroy', $item->id) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm confirm-delete"><i
                                                            class="ti-trash"></i></button>
                                            @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal --}}

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="page" class="p-2"></div>
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

    <script>
        // Tampilan Modal Create
        function create() {
            $.get("{{ route('mata-pelajaran.create') }}", {}, function(data, status) {
                $("#staticBackdropLabel").html('Tambah Mata Pelajaran');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");

            });
        }

        // Prosess Store
        function store() {
            event.preventDefault();
            var dataToForm = $("#form-mata-pelajaran").serialize();

            $.ajax({
                type: "POST",
                url: "{{ route('mata-pelajaran.store') }}",
                data: dataToForm,
                success: function(response) {
                    if (response.status === 200) {
                        $(".btn-close").click();
                        window.location.reload();
                    } else if (response.status === 400) {
                        $("input, select, textarea").removeClass('is-invalid');
                        $.each(response.errors, function(key, value) {
                            $("#" + key).addClass('is-invalid');
                            $("#" + key + "Feedback").text(value[0]);
                        });
                    } else if (response.status === 409) {
                        $(".btn-close").click();
                        window.location.reload();
                    }
                }
            });
        }

        // Tampilan Modal Eidt
        function edit(id) {
            $.get("{{ url('mata-pelajaran') }}/" + id + "/edit", {}, function(data, status) {
                $("#staticBackdropLabel").html('Edit Mata Pelajaran');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Proses Edit
        function update(id) {
            event.preventDefault();
            var dataToForm = $("#form-mata-pelajaran").serialize();

            $.ajax({
                type: "PUT",
                url: "{{ url('mata-pelajaran') }}/" + id,
                data: dataToForm,
                success: function(response) {
                    if (response.status === 200) {
                        $(".btn-close").click();
                        window.location.reload()

                    } else if (response.status === 400) {
                        var errors = response.errors;
                        if (errors.name) {
                            $("#name").addClass('is-invalid');
                            $("#nameFeedback").text(errors.name[0]);
                        }
                    }
                }
            });
        }

        // Delete
        $('.confirm-delete').click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Sukses',
                        'Data berhasil dihapus',
                        'success'
                    )
                    form.submit();
                }
            })
        });
    </script>
@endpush
