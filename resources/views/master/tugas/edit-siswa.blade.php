<form id="form-tugas-siswa" method="POST" action="{{ route('tugas.siswa.update', [$pengumpulan->tugas->id, $pengumpulan->id]) }}" enctype="multipart/form-data" id="form-tugas-siswa">
    @csrf
    @method('PUT')
    <div class="row">
        @if ($pengumpulan->file)
            <div class="col-md-12">
                <label for="image" class="form-label">File Jawab</label>
                <div class="mb-3">
                    <iframe src="{{ asset('storage/file_jawaban/' . $pengumpulan->file) }}" frameborder="0" class="w-100"
                        style="height: 400px;"></iframe>
                </div>
            </div>
        @endif

        <div class="col-md-6">
            <div class="mb-3">
                <label for="tgl" class="form-label">Tanggal Pengumpulan</label>
                <input type="text" class="form-control" id="tgl"
                    value="{{ $pengumpulan->created_at->format('d-m-Y H:i') }}" disabled>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="tgl" class="form-label">Status Pengumpulan</label>
                @if ($pengumpulan->status == true)
                    <input type="text" class="form-control" id="tgl" value="Sudah Dikerjakan" disabled>
                @else
                    <input type="text" class="form-control" id="tgl" value="Belum Dikerjakan" disabled>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="tgl" class="form-label">Status Keterlambatan</label>
                @if ($pengumpulan->tugas->batas_waktu < now())
                    <input type="text" class="form-control" id="tgl" value="Terlambat" disabled>
                @else
                    <input type="text" class="form-control" id="tgl" value="Tidak Terlambat" disabled>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="nilai" class="form-label">Nilai</label>
                <input type="number" class="form-control" id="nilai" name="nilai"
                    value="{{ $pengumpulan->nilai }}" placeholder="Masukkan Nilai" min="0" max="{{ $pengumpulan->tugas->nilai_maksimal }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3">
                <label for="jawaban" class="form-label">Jawaban</label>
                <textarea class="form-control" id="jawaban" name="jawaban" rows="3" disabled>{{ $pengumpulan->jawaban }}</textarea>
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3">
                <label for="komentar_guru" class="form-label">Komentar</label>
                <textarea class="form-control" id="komentar_guru" name="komentar_guru" rows="3" placeholder="">{{ $pengumpulan->komentar_guru }}</textarea>
                <div id="komentar_guruFeedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>


        <button type="button" class="btn btn-primary mb-3" onclick="update({{ $pengumpulan->tugas->id }}, {{ $pengumpulan->id }})">Simpan</button>
    </form>
</form>
