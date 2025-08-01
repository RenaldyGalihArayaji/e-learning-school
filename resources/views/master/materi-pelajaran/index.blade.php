@extends('master.layouts.app')

@section('content')
    <div class="title">
        <h1 class="h3 mb-0 text-gray-800">Mata Pelajaran | <span
                class="text-secondary fs-5">{{ ucwords($mataPelajaran->nama_mata_pelajaran) }} </span></h1>
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Materi Pelajaran</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button class="btn mb-3 icon-left btn-primary btn-sm"
                                    onclick="create({{ $mataPelajaran->id }})"><i class="ti-plus"></i>Tambah Data</button>
                            </div>
                            <div>
                                <a href="{{ route('mata-pelajaran.index') }}"
                                    class="btn mb-3 icon-left btn-secondary btn-sm "><i
                                        class="bi bi-arrow-left-circle me-2"></i>Kembali</a>
                            </div>
                        </div>

                        <div>
                            <table id="example2" class="table dt-responsive display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Materi</th>
                                        <th>Tanggal Upload</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($materiPelajaran as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ ucwords($item->judul) }}</td>
                                            <td>{{ $item->tanggal_upload }}</td>
                                            <td>{{ ucwords($item->deskripsi) }}</td>
                                            <td>
                                                <button class="btn btn-outline-warning btn-sm my-1"
                                                    onclick="show({{ $item->id }})">
                                                    <i class="ti-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-success btn-sm"
                                                    onclick="edit({{ $item->id }})"><i
                                                        class="ti-pencil-alt"></i></button>
                                                <form action="{{ route('materi-pelajaran.destroy', $item->id) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm confirm-delete"><i
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
            function create(id) {
                $.get("{{ url('materi-pelajaran/create') }}/" + id, {}, function(data, status) {
                    $("#staticBackdropLabel").html('Tambah materi Pelajaran');
                    $("#page").html(data);
                    $("#staticBackdrop").modal("show");
                });
            }

            // Prosess Store
            function store(id) {
                event.preventDefault();
                var formData = new FormData($("#form-materi-pelajaran")[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ url('materi-pelajaran/store') }}/" + id,
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
                $.get("{{ url('materi-pelajaran/edit/') }}/" + id, {}, function(data, status) {
                    $("#staticBackdropLabel").html('Edit Materi Pelajaran');
                    $("#page").html(data);
                    $("#staticBackdrop").modal("show");
                });
            }

            // Proses Edit
            function update(id) {
                event.preventDefault();
                var formData = new FormData($("#form-materi-pelajaran")[0]);
                formData.append('_method', 'PUT');
                $.ajax({
                    type: "POST",
                    url: "{{ url('materi-pelajaran/update') }}/" + id,
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
                $.get("{{ url('materi-pelajaran/show') }}/" + id, {}, function(data, status) {
                    $("#staticBackdropLabel").html('Detail Materi Pelajaran');
                    $("#page").html(data);
                    $("#staticBackdrop").modal("show");
                });
            }
        </script>
    @endpush
