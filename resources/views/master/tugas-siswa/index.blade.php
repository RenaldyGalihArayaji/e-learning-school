@extends('master.layouts.app')

@section('content')
    <div class="title">
        <h1 class="h3 mb-0 text-gray-800">Daftar Tugas Anda</h1>
    </div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-md-12">
                <hr>
            </div>
            @forelse($tugas as $item)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-lg modern-task-card position-relative overflow-hidden"
                        onclick="create({{ $item->id }})" style="cursor: pointer;">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center">
                                    <h1>{{ ucwords($item->judul) }}</h1>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            <span class="fw-semibold">
                                                <i class="fa fa-book me-1"></i> Mapel: </span>
                                            {{ ucwords($item->mataPelajaran->nama_mata_pelajaran) }}
                                        </h6>

                                    </div>
                                    @if ($item->batas_waktu < now())
                                        <div>
                                            <span class="badge bg-danger text-light">
                                                <i class="fa fa-clock me-1"></i>Terlambat
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <h6 class="card-subtitle mb-2 text-muted">
                                    <span class="fw-semibold">
                                        <i class="fa fa-user me-1"></i> Guru: </span>
                                    {{ ucwords($item->pegawai->nama_lengkap) }}
                                </h6>

                                <h6 class="card-subtitle mb-2 text-muted">
                                    <span class="fw-semibold">
                                        <i class="fa fa-calendar-alt me-1"></i> Batas Waktu: </span>
                                    {{ \Carbon\Carbon::parse($item->batas_waktu)->format('d M Y H:i') }}
                                </h6>

                                <h6 class="card-subtitle mb-2 text-muted">
                                    <span class="fw-semibold">
                                        <i class="fa fa-star me-1"></i> Poin: </span> {{ $item->nilai_maksimal }}
                                </h6>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <span class="fw-semibold">
                                        <i class="fa fa-info-circle me-1"></i> Status:
                                    </span>
                                    @php
                                        $pengumpulan = $item->pengumpulanTugas->first();
                                    @endphp
                                    @if ($pengumpulan && $pengumpulan->status == true)
                                        <span class="badge bg-success text-light">
                                            <i class="fa fa-check-circle me-1"></i> Sudah Dikerjakan
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="fa fa-times-circle me-1"></i> Belum Dikerjakan
                                        </span>
                                    @endif
                                </h6>

                                <hr>

                                <h6>
                                    <i class="fa fa-info-circle me-1"></i> <strong>Deskripsi:</strong>
                                    <p class="mt-2">
                                        @if ($item->deskripsi)
                                            <span class="text-justify">
                                                {{ ucwords($item->deskripsi) }}
                                            </span>
                                        @else
                                            <span class="text-muted">Tidak ada deskripsi</span>
                                        @endif
                                    </p>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="alert alert-info text-center" role="alert">
                        Belum ada tugas yang tersedia.
                    </div>
                </div>
            @endforelse
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
            $.get("{{ url('pengumpulan-tugas/create') }}/" + id, {}, function(data, status) {
                $("#staticBackdropLabel").html('Tambah Pengumpulan Tugas');
                $("#page").html(data);
                $("#staticBackdrop").modal("show");
            });
        }

        // // Prosess Store
        function store(id) {
            event.preventDefault();
            var formData = new FormData($("#form-pengumpulan-tugas")[0]);

            $.ajax({
                type: "POST",
                url: "{{ url('pengumpulan-tugas/store') }}/" + id,
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
    </script>
@endpush
