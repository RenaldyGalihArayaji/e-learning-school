<form id="form-pengumpulan-tugas" action="{{ route('pengumpulan-tugas.store', $tugas->id) }}"
    enctype="multipart/form-data">
    @csrf

    @php
        $pengumpulan = $tugas->pengumpulanTugas->first();
    @endphp

    <div class="row">
        <div class="col-md-12">
            <label for="image" class="form-label">File Materi</label>
            <div class="mb-3">
                <iframe src="{{ asset('storage/file_tugas/' . $tugas->type_file) }}" frameborder="0" class="w-100"
                    style="height: 400px;"></iframe>
            </div>
        </div>

        @if ($tugas->url_file)
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="mb-2">
                            <label for="url_file" class="form-label fw-bold">URL File Tugas:</label>
                        </div>
                        <div>
                            <a href="{{ $tugas->url_file }}" target="_blank"
                                class="btn btn-outline-primary btn-sm w-100">
                                <i class="bi bi-file-earmark-text"></i> Lihat File
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($pengumpulan && $pengumpulan->status == true)
            @if ($pengumpulan->nilai)
                <div class="col-md-6">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="mb-2">
                                <label for="url_file" class="form-label fw-bold">Nilai:</label>
                            </div>
                            <div>
                                <input type="number" class="form-control" id="nilai" name="nilai"
                                    value="{{ $pengumpulan->nilai }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        <hr>
        <h6 class="mb-2">Jawaban</h6>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="tanggal_pengumpulan" class="form-label fw-bold">Tanggal Pengumpulan</label>
                <input type="text" class="form-control bg-light" id="tanggal_pengumpulan" name="tanggal_pengumpulan"
                    value="{{ now()->format('Y-m-d H:i:s') }}" readonly>
                <div id="tanggal_pengumpulanFeedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="file" class="form-label fw-bold">File Tugas (Opsional) <span class="text-danger">*jpg,jpeg,png,pdf*</span></label>
                @if ($pengumpulan && $pengumpulan->status == true)
                    <input type="file" class="form-control bg-light" id="file" name="file" disabled>
                @else
                    <input type="file" class="form-control bg-light" id="file" name="file">
                @endif
                <div id="fileFeedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3">
                @if ($pengumpulan && $pengumpulan->status == true)
                    <textarea class="form-control" id="jawaban" name="jawaban" placeholder="Masukan Jawaban" rows="3" disabled>{{ $pengumpulan->jawaban }}</textarea>
                @else
                    <textarea class="form-control" id="jawaban" name="jawaban" placeholder="Masukan Jawaban" rows="3"></textarea>
                @endif
                <div id="jawabanFeedback" class="invalid-feedback"></div>
            </div>
        </div>

        @if ($pengumpulan && $pengumpulan->status == true)
            @if ($pengumpulan->komentar_guru)
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar</label>
                        <textarea class="form-control" id="komentar" name="komentar" rows="3" disabled>{{ $pengumpulan->komentar_guru }}</textarea>
                        <div id="komentarFeedback" class="invalid-feedback"></div>
                    </div>
                </div>
            @endif
        @endif

    </div>

    @if ($pengumpulan)
        @if ($pengumpulan->status == false)
            <button type="button" class="btn btn-primary mb-3" onclick="store({{ $tugas->id }})">Simpan</button>
        @endif
    @else
        <button type="button" class="btn btn-primary mb-3" onclick="store({{ $tugas->id }})">Simpan</button>
    @endif
</form>
