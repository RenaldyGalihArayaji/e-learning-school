@extends('master.layouts.app')

@section('content')
    <div class="title">
        <h1 class="h3 mb-0 text-gray-800">Tugas | <span class="text-secondary fs-5">{{ ucwords($tugas->judul) }}</span></h1>
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
                                <a href="{{ route('tugas.index') }}"
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tugas->pengumpulanTugas as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucwords($item->siswa->nama_lengkap) }}</td>
                                        <td>{{ $item->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td>{{ $item->siswa->angkatan }}</td>
                                        <td>{{ $item->siswa->kelas->nama_kelas }}</td>
                                        <td>
                                            <button class="btn btn-outline-success btn-sm"
                                                onclick="edit({{ $tugas->id }}, {{ $item->id }})">
                                                <i class="ti-pencil-alt"></i>
                                            </button>
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

        // Tampilan Modal Eidt
        function edit(tugas_id, pengumpulan_id) {
            $.get("{{ url('tugas') }}/" + tugas_id + "/siswa/" + pengumpulan_id + "/edit", {}, function(data) {
                $("#staticBackdropLabel").html('Detail Pengumpulan Tugas');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // Update Pengumpulan Tugas
       function update(tugas_id, pengumpulan_id) {
            event.preventDefault();
            var formData = new FormData($("#form-tugas-siswa")[0]);
            formData.append('_method', 'PUT');

            $.ajax({
                type: "POST",
                url: "{{ url('tugas') }}/" + tugas_id + "/siswa/" + pengumpulan_id + "/update",
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

    </script>
@endpush
