<form id="form-siswa" method="POST" action="{{ route('siswa.update', $siswa->id) }}">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                    value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}">
                <div id="nama_lengkapFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="nisn" class="form-label">NISN <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nisn" name="nisn"
                    value="{{ old('nisn', $siswa->nisn) }}" placeholder="Masukan NISN">
                <div id="nisnFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="nis" class="form-label">NIS <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nis" name="nis"
                    value="{{ old('nis', $siswa->nis) }}" placeholder="Masukan NIS">
                <div id="nisFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                    <option value="" disabled
                        {{ old('jenis_kelamin', $siswa->jenis_kelamin) == null ? 'selected' : '' }}>--Pilih--</option>
                    <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                        Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                        Perempuan</option>
                </select>
                <div id="jenis_kelaminFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                    value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" placeholder="Masukan Tempat Lahir Anda">
                <div id="tempat_lahirFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                    value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                <div id="tanggal_lahirFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="angkatan" class="form-label">Angkatan</label>
                <input type="text" class="form-control" id="angkatan" name="angkatan"
                    value="{{ old('angkatan', $siswa->angkatan) }}" placeholder="Cth. 2023/2024">
                <div id="angkatanFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="kelas_id" class="form-label">Kelas<span class="text-danger">*</span></label>
                <select name="kelas_id" id="kelas_id" class="form-control">
                    <option value="" disabled {{ old('kelas_id', $siswa->kelas_id) == null ? 'selected' : '' }}>
                        --Pilih--</option>
                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}"
                            {{ old('kelas_id', $siswa->kelas_id) == $item->id ? 'selected' : '' }}>
                            {{ ucwords($item->nama_kelas) }}
                        </option>
                    @endforeach
                </select>
                <div id="kelas_idFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="no_telp" class="form-label">No Telepon</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp"
                    value="{{ old('no_telp', $siswa->no_telp) }}" placeholder="08xxxxxxxx">
                <div id="no_telpFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="{{ old('email', $siswa->email) }}" placeholder="test@example.com">
                <div id="emailFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukan Alamat Anda" rows="3">{{ old('alamat', $siswa->alamat) }}</textarea>
                <div id="alamatFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="username" name="username"
                    value="{{ old('username', $siswa->user->username) }}" placeholder="Masukan Username Anda">
                <div id="usernameFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="xxxxxxxxx"
                    value="{{ old('password') }}">
                <div id="passwordFeedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary mb-3" onclick="update({{ $siswa->id }})">Simpan</button>
</form>
