<form id="form-tugas" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="judul" class="form-label">Nama Tugas <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="judul" name="judul"
                    placeholder="Masukkan nama tugas">
                <div id="judulFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                <select class="form-select" id="mata_pelajaran_id" name="mata_pelajaran_id">
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach ($mataPelajaran as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_mata_pelajaran }} | {{ $item->kelas->nama_kelas }} </option>
                    @endforeach
                </select>
                <div id="mata_pelajaran_idFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="batas_waktu" class="form-label">Batas Pengumpulan <span class="text-danger">*</span></label>
                <input type="datetime-local" class="form-control" id="batas_waktu" name="batas_waktu"
                    placeholder="Masukkan nama tugas">
                <div id="batas_waktuFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="url_file" class="form-label">URL File Tugas</label>
                <input type="text" class="form-control" id="url_file" name="url_file" placeholder="Masukkan URL File Tugas">
                <div id="url_fileFeedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="type_file" class="form-label">File Tugas</label>
                <input type="file" class="form-control" id="type_file" name="type_file">
                <div id="type_fileFeedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="nilai_maksimal" class="form-label">Poin Nilai</label>
                <input type="number" class="form-control" id="nilai_maksimal" name="nilai_maksimal" placeholder="Masukkan Poin Nilai">
                <div id="nilai_maksimalFeedback" class="invalid-feedback"></div>
            </div>
        </div>

         <div class="col-md-12">
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukan Deskripsi" rows="3"></textarea>
                <div id="deskripsiFeedback" class="invalid-feedback"></div>
            </div>
        </div>


    </div>

    <button type="button" class="btn btn-primary mb-3" onclick="store()">Simpan</button>
</form>
