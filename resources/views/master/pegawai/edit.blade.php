<form id="form-pegawai" method="POS" action="{{ route('pegawai.update', $pegawai->id) }}">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                    value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}" placeholder="Masukan Nama Lengkap Anda">
                <div id="nama_lengkapFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nip" name="nip"
                    value="{{ old('nip', $pegawai->nip) }}" placeholder="Masukan NIP Anda">
                <div id="nipFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                    <option value="" disabled
                        {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == '' ? 'selected' : '' }}>--Pilih--</option>
                    <option value="L" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                        Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                        Perempuan</option>
                </select>
                <div id="jenis_kelaminFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                    value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}" placeholder="Masukan Tempat Lahir Anda">
                <div id="tempat_lahirFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                    value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}">
                <div id="tanggal_lahirFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="jabatan" name="jabatan"
                    value="{{ old('jabatan', $pegawai->jabatan) }}" placeholder="Cth: Guru Bk">
                <div id="jabatanFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="status_pegawai" class="form-label">Status Pegawai <span class="text-danger">*</span></label>
                <select name="status_pegawai" id="status_pegawai" class="form-control">
                    <option value="" disabled
                        {{ old('status_pegawai', $pegawai->status_pegawai) == '' ? 'selected' : '' }}>--Pilih--</option>
                    <option value="pns"
                        {{ old('status_pegawai', $pegawai->status_pegawai) == 'pns' ? 'selected' : '' }}>PNS</option>
                    <option value="honorer"
                        {{ old('status_pegawai', $pegawai->status_pegawai) == 'honorer' ? 'selected' : '' }}>Honorer
                    </option>
                </select>
                <div id="status_pegawaiFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="no_telp" class="form-label">No Telepon</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp"
                    value="{{ old('no_telp', $pegawai->no_telp) }}" placeholder="08xxxxxxxx">
                <div id="no_telpFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="email" class="form-label">email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="{{ old('email', $pegawai->user->email) }}" placeholder="test@example.com">
                <div id="emailFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukan Alamat Anda" rows="3">{{ old('alamat', $pegawai->alamat) }}</textarea>
                <div id="alamatFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="username" name="username"
                    value="{{ old('username', $pegawai->user->username) }}" placeholder="Masukan Username Anda">
                <div id="usernameFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="xxxxxxxxx"
                    value="{{ old('password') }}">
                <div id="passwordFeedback" class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="role" class="form-label">Roles</label>
                <select class="form-control" id="role" name="role">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ in_array($role->id, $userRoles) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <div id="roleFeedback" class="invalid-feedback"></div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary mb-3" onclick="update({{$pegawai->id}})">Simpan</button>
</form>
