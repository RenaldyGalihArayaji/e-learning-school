@extends('master.layouts.app')

@section('content')
    <div class="title">
        <h1 class="h3 mb-0 text-gray-800">Data Tugas</h1>
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Data Tugas</h4>
                    </div>
                    <div class="card-body">
                        <button class="btn mb-3 icon-left btn-primary btn-sm" onclick="create()"><i class="ti-plus"></i>Tambah
                            Data</button>
                        <table id="example2" class="table dt-responsive display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tugas</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Poin Nilai</th>
                                    <th>Tanggal Upload</th>
                                    <th>Batas Waktu Pengumpulan</th>
                                    <th>Guru Pengampu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tugas as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucwords($item->judul) }}</td>
                                        <td>{{ ucwords($item->mataPelajaran->nama_mata_pelajaran) }}</td>
                                        <td>{{ ucwords($item->mataPelajaran->kelas->nama_kelas) }}</td>
                                        <td>{{ $item->nilai_maksimal }}</td>
                                        <td>{{ $item->tanggal_upload }}</td>
                                        <td>{{ $item->batas_waktu }}</td>
                                        <td>{{ ucwords($item->pegawai->nama_lengkap) }}</td>
                                        <td>
                                            <a href="{{ route('tugas.siswa', $item->id) }}"
                                                class="btn btn-outline-primary btn-sm my-1">Lihat Siswa</a>
                                            <button class="btn btn-outline-warning btn-sm my-1" onclick="show({{ $item->id }})">
                                                <i class="ti-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-success btn-sm" onclick="edit({{ $item->id }})"><i
                                                    class="ti-pencil-alt"></i></button>
                                            <form action="{{ route('tugas.destroy', $item->id) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-outline-danger btn-sm confirm-delete"><i
                                                        class="ti-trash"></i></button>
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

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        // Tampilan Modal Create
        function create() {
            $.get("{{ route('tugas.create') }}", {}, function(data, status) {
                $("#staticBackdropLabel").html('Tambah Tugas');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");

            });
        }

        // Prosess Store
        function store() {
            event.preventDefault();
            var formData = new FormData($("#form-tugas")[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('tugas.store') }}",
                data: formData,
                processData: false,
                contentType: false,
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
            $.get("{{ url('tugas') }}/" + id + "/edit", {}, function(data, status) {
                $("#staticBackdropLabel").html('Edit tugas');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Proses Edit
        function update(id) {
            event.preventDefault();
            var formData = new FormData($("#form-tugas")[0]);
            formData.append('_method', 'PUT');

            $.ajax({
                type: "POST",
                url: "{{ url('tugas') }}/" + id,
                data: formData,
                processData: false,
                contentType: false,
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

        // Show Detail
        function show(id) {
            $.get("{{ url('tugas') }}/" + id, {}, function(data, status) {
                $("#staticBackdropLabel").html('Detail Tugas');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }
    </script>
@endpush
