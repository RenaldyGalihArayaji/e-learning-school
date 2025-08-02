<form id="form-mata-pelajaran" method="POST" action="{{ route('mata-pelajaran.update', $mataPelajaran->id) }}">
    @method('PUT')
    @csrf
      <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="nama_mata_pelajaran" class="form-label">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_mata_pelajaran" name="nama_mata_pelajaran"
                    value="{{ old('nama_mata_pelajaran', $mataPelajaran->nama_mata_pelajaran) }}">
                <div id="nama_mata_pelajaranFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                <select class="form-select" id="kelas_id" name="kelas_id">
                    <option value="" disabled {{ old('kelas_id', $mataPelajaran->kelas_id) == null ? 'selected' : '' }}>--Pilih--</option>
                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}" {{ old('kelas_id', $mataPelajaran->kelas_id) == $item->id ? 'selected' : '' }}>
                            {{ ucwords($item->nama_kelas) }}
                        </option>
                    @endforeach
                </select>
                <div id="kelas_idFeedback" class="invalid-feedback"></div>
            </div>
        </div>
         <div class="col-md-6">
            <div class="mb-3">
                <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="tahun_ajaran_id" name="tahun_ajaran_id"
                    value="{{ $mataPelajaran->tahunAjaran->nama_tahun_ajaran }}" disabled>
                    <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaran->id }}">
                <div id="tahun_ajaran_idFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="guru_pengampu_id" class="form-label">Wali Kelas <span class="text-danger">*</span></label>
                <select class="form-select" id="guru_pengampu_id" name="guru_pengampu_id">
                    <option value="" disabled {{ old('guru_pengampu_id', $mataPelajaran->guru_pengampu_id) == null ? 'selected' : '' }}>--Pilih--</option>
                    @foreach ($guruPengampu as $item)
                        <option value="{{ $item->id }}" {{ old('guru_pengampu_id', $mataPelajaran->guru_pengampu_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
                <div id="guru_pengampu_idFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukan Deskripsi" rows="3">{{ old('deskripsi', $mataPelajaran->deskripsi) }}</textarea>
                <div id="deskripsiFeedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary mb-3" onclick="update({{ $mataPelajaran->id }})">Simpan</button>
</form>
