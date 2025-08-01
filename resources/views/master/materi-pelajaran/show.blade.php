<div class="row mb-3">
    <h5 class="mb-3"><i class="ti-calendar"></i> Detail Materi</h5>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tgl" class="form-label">Tanggal Upload</label>
                    <input type="text" class="form-control" id="tgl" value="{{ ucwords($materi->tanggal_upload) }}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tgl" class="form-label">Judul Materi</label>
                    <input type="text" class="form-control" id="tgl" value="{{ ucwords($materi->judul) }}" disabled>
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="tgl" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="event_description" rows="3" disabled>{{ ucwords($materi->deskripsi) }}</textarea>
                </div>
            </div>

        </div>
    </div>

    <!-- Event Poster -->
    <div class="col-md-12">
        <label for="image" class="form-label">File Materi</label>
        <div class="mb-3">
              <iframe src="{{ asset('storage/materi/' . $materi->type_file) }}" frameborder="0" class="w-100" style="height: 400px;"></iframe>
        </div>
    </div>

    @if ($materi->url_file)
    <div class="col-md-12">
        <div class="mb-3">
            <label for="url_file" class="form-label">URL File Materi</label>
            <a href="{{ $materi->url_file }}" target="_blank" class="btn btn-primary btn-sm ms-2">
                Lihat File
            </a>
        </div>
    </div>
@endif
</div>

