<form id="form-kelas">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="nama_kelas" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_kelas" name="nama_kelas"
                    placeholder="XII RPL 1">
                <div id="nama_kelasFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="tahun_ajaran" class="form-label">Tahun Ajaran<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran"
                    value="{{ $tahunAjaran->nama_tahun_ajaran }}" disabled>
                <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaran->id }}">
                <div id="tahun_ajaran_idFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        {{-- <div class="col-md-4">
            <div class="mb-3">
                <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                <select class="form-select" id="tahun_ajaran_id" name="tahun_ajaran_id">
                    <option value="">Pilih Tahun Ajaran</option>
                    @foreach ($tahunAjaran as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_tahun_ajaran }}</option>
                    @endforeach
                </select>
                <div id="tahun_ajaran_idFeedback" class="invalid-feedback"></div>
            </div>
        </div> --}}
        <div class="col-md-4">
            <div class="mb-3">
                <label for="pegawai_id" class="form-label">Wali Kelas <span class="text-danger">*</span></label>
                <select class="form-select" id="pegawai_id" name="pegawai_id">
                    <option value="">Pilih Wali Kelas</option>
                    @foreach ($pegawai as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_lengkap }}</option>
                    @endforeach
                </select>
                <div id="pegawai_idFeedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary mb-3" onclick="store()">Simpan</button>
</form>
