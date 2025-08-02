<form id="form-tugas" method="POST" action="{{ route('tugas.update', $tugas->id) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="judul" class="form-label">Nama Tugas <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="judul" name="judul"
                    value="{{ $tugas->judul }}" placeholder="Masukkan nama tugas">
                <div id="judulFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                <select class="form-select" id="mata_pelajaran_id" name="mata_pelajaran_id">
                    <option value="" disabled {{ old('mata_pelajaran_id', $tugas->mata_pelajaran_id) == null ? 'selected' : '' }}>--Pilih--</option>
                    @foreach ($mataPelajaran as $item)
                        <option value="{{ $item->id }}" {{ old('mata_pelajaran_id', $tugas->mata_pelajaran_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_mata_pelajaran }} | {{ $item->kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                <div id="mata_pelajaran_idFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="batas_waktu" class="form-label">Batas Pengumpulan <span class="text-danger">*</span></label>
                <input type="datetime-local" class="form-control" id="batas_waktu" name="batas_waktu" value="{{ $tugas->batas_waktu }}">
                <div id="batas_waktuFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="url_file" class="form-label">URL File Tugas</label>
                <input type="text" class="form-control" id="url_file" name="url_file" value="{{ $tugas->url_file }}"
                    placeholder="Masukkan URL File Tugas">
                <div id="url_fileFeedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="type_file" class="form-label">File Tugas <span class="text-danger">*jpg,jpeg,png,pdf*</span></label>
                <input type="file" class="form-control" id="type_file" name="type_file">
                <div id="type_fileFeedback" class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label for="nilai_maksimal" class="form-label">Poin Nilai</label>
                <input type="number" class="form-control" id="nilai_maksimal" name="nilai_maksimal" value="{{ $tugas->nilai_maksimal }}"
                    placeholder="Masukkan Poin Nilai">
                <div id="nilai_maksimalFeedback" class="invalid-feedback"></div>
            </div>
        </div>

         <div class="col-md-12">
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukan Deskripsi" rows="3">{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
                <div id="deskripsiFeedback" class="invalid-feedback"></div>
            </div>
        </div>


    </div>
    <button type="button" class="btn btn-primary mb-3" onclick="update({{ $tugas->id }})">Simpan</button>
</form>
