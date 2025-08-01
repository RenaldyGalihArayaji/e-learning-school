<div class="row mb-3">
    <h5 class="mb-3"><i class="ti-calendar"></i> Detail Tugas</h5>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tgl" class="form-label">Tanggal Upload</label>
                    <input type="text" class="form-control" id="tgl" value="{{ ucwords($tugas->tanggal_upload) }}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tgl" class="form-label">Nama Tugas</label>
                    <input type="text" class="form-control" id="tgl" value="{{ ucwords($tugas->judul) }}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tgl" class="form-label">Mata Pelajaran</label>
                    <input type="text" class="form-control" id="tgl" value="{{ ucwords($tugas->mataPelajaran->nama_mata_pelajaran) }}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tgl" class="form-label">Kelas</label>
                    <input type="text" class="form-control" id="tgl" value="{{ ucwords($tugas->mataPelajaran->kelas->nama_kelas) }}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tgl" class="form-label">Poin Nilai</label>
                    <input type="text" class="form-control" id="tgl" value="{{ ucwords($tugas->nilai_maksimal) }}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tgl" class="form-label">Guru Pengampu</label>
                    <input type="text" class="form-control" id="tgl" value="{{ ucwords($tugas->pegawai->nama_lengkap) }}" disabled>
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="tgl" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="event_description" rows="3" disabled>{{ ucwords($tugas->deskripsi) }}</textarea>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-12">
        <label for="image" class="form-label">File Tugas</label>
        <div class="mb-3">
              <iframe src="{{ asset('storage/file_tugas/' . $tugas->type_file) }}" frameborder="0" class="w-100" style="height: 400px;"></iframe>
        </div>
    </div>

    @if ($tugas->url_file)
    <div class="col-md-12">
        <div class="mb-3">
            <label for="url_file" class="form-label">URL File Tugas</label>
            <a href="{{ $tugas->url_file }}" target="_blank" class="btn btn-primary btn-sm ms-2">
                Lihat File
            </a>
        </div>
    </div>
@endif
</div>

