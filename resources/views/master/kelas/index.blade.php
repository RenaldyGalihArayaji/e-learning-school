@extends('master.layouts.app')

@section('content')
    <div class="title">
        <h1 class="h3 mb-0 text-gray-800">Master | <span class="text-secondary fs-5">Kelas</span></h1>
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Kelas</h4>
                    </div>
                    <div class="card-body">
                        <button class="btn mb-3 icon-left btn-primary btn-sm" onclick="create()"><i
                                class="ti-plus"></i>Tambah Data</button>
                        <table id="example2" class="table dt-responsive display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Wali kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucwords($item->nama_kelas)  }}</td>
                                        <td>{{ ucwords($item->tahunAjaran->nama_tahun_ajaran)  }}</td>
                                        <td>{{ ucwords($item->pegawai->nama_lengkap)  }}</td>
                                        <td>
                                            <button class="btn btn-outline-success btn-sm" onclick="edit({{ $item->id }})"><i
                                                    class="ti-pencil-alt"></i></button>
                                            <form action="{{ route('kelas.destroy', $item->id) }}" method="post"
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
            $.get("{{ route('kelas.create') }}", {}, function(data, status) {
                $("#staticBackdropLabel").html('Tambah Kelas');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");

            });
        }

        // Prosess Store
        function store() {
            event.preventDefault();
            var dataToForm = $("#form-kelas").serialize();

            $.ajax({
                type: "POST",
                url: "{{ route('kelas.store') }}",
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
            $.get("{{ url('master/kelas') }}/" + id + "/edit", {}, function(data, status) {
                $("#staticBackdropLabel").html('Edit Kelas');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Proses Edit
        function update(id) {
            event.preventDefault();
            var dataToForm = $("#form-kelas").serialize();

            $.ajax({
                type: "PUT",
                url: "{{ url('master/kelas') }}/" + id,
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
