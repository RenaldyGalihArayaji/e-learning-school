<form id="form-materi-pelajaran" method="POST" action="{{ route('materi-pelajaran.update', $materi->id) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Materi <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="judul" name="judul"
                    value="{{ $materi->judul }}">
                <div id="judulFeedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="url_file" class="form-label">URL File Materi</label>
                <input type="text" class="form-control" id="url_file" name="url_file"
                    value="{{ $materi->url_file }}">
                <div id="url_fileFeedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="type_file" class="form-label">File Materi</label>
                <input type="file" class="form-control" id="type_file" name="type_file"
                    placeholder="Masukan Nama Mata Pelajaran">
                <div id="type_fileFeedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukan Deskripsi" rows="3">{{ old('deskripsi', $materi->deskripsi) }}</textarea>
                <div id="deskripsiFeedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>


    <button type="button" class="btn btn-primary mb-3" onclick="update({{ $materi->id }})">Simpan</button>
</form>
