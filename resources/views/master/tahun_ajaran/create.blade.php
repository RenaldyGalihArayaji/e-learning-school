<form id="form-tahun-ajaran">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="nama_tahun_ajaran" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_tahun_ajaran" name="nama_tahun_ajaran"
                    placeholder="Cth: 2023/2024">
                <div id="nama_tahun_ajaranFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="" disabled selected>--Pilih--</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
                <div id="statusFeedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary mb-3" onclick="store()">Simpan</button>
</form>
