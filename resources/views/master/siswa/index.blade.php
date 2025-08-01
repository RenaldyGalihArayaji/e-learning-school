@extends('master.layouts.app')

@section('content')
    <div class="title">
        <h1 class="h3 mb-0 text-gray-800">Master | <span class="text-secondary fs-5">Siswa</span></h1>
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Siswa</h4>
                    </div>
                    <div class="card-body">
                        <button class="btn mb-3 icon-left btn-primary btn-sm" onclick="create()"><i
                                class="ti-plus"></i>Tambah Data</button>
                        <table id="example2" class="table dt-responsive display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Angkatan</th>
                                    <th>Kelas</th>
                                    <th>Username</th>
                                    <th>Aksi</th>
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
                                        <td>{{ ucwords($item->user->username) }}</td>
                                        <td>
                                            <button class="btn btn-outline-success btn-sm" onclick="edit({{ $item->id }})"><i
                                                    class="ti-pencil-alt"></i></button>
                                            <form action="{{ route('siswa.destroy', $item->id) }}" method="post"
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
        // Tampilan Modal Create
        function create() {
            $.get("{{ route('siswa.create') }}", {}, function(data, status) {
                $("#staticBackdropLabel").html('Tambah Siswa');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");

            });
        }

        // Prosess Store
        function store() {
            event.preventDefault(); // Mencegah form submit default
            var dataToForm = $("#form-siswa").serialize(); //Mengambil data di dalam form

            $.ajax({
                type: "POST",
                url: "{{ route('siswa.store') }}",
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
            $.get("{{ url('master/siswa') }}/" + id + "/edit", {}, function(data, status) {
                $("#staticBackdropLabel").html('Edit Siswa');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Proses Edit
        function update(id) {
            event.preventDefault(); // Mencegah form submit default
            var dataToForm = $("#form-siswa").serialize(); //Mengambil data di dalam form

            $.ajax({
                type: "PUT",
                url: "{{ url('master/siswa') }}/" + id,
                data: dataToForm,
                success: function(response) {
                    if (response.status === 200) {
                        $(".btn-close").click(); // Menutup modal setelah alert ditutup
                        window.location.reload()

                    } else if (response.status === 400) {
                        // Jika ada error, tampilkan pesan error
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
                // text: "Data Akan di Hapus",
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
