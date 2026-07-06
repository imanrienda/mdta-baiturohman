@extends('layouts.public')

@section('title', 'Form Pendaftaran')
@section('header', 'Form Pendaftaran Siswa Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Isi Data Pendaftaran</h3>
    </div>
    <div class="card-body">

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Terdapat kesalahan!</h5>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- DATA DIRI --}}
            <h5 class="mb-3 text-muted border-bottom pb-2">
                <i class="fas fa-user mr-1"></i> Data Diri Calon Siswa
            </h5>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">
                    Nama Lengkap <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <input type="text" name="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}"
                        placeholder="Nama lengkap sesuai akta kelahiran">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">NISN</label>
                <div class="col-sm-9">
                    <input type="text" name="nisn"
                        class="form-control @error('nisn') is-invalid @enderror"
                        value="{{ old('nisn') }}"
                        placeholder="Nomor Induk Siswa Nasional (opsional)">
                    @error('nisn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">
                    Tempat Lahir <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <input type="text" name="tempat_lahir"
                        class="form-control @error('tempat_lahir') is-invalid @enderror"
                        value="{{ old('tempat_lahir') }}"
                        placeholder="Kota tempat lahir">
                    @error('tempat_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">
                    Tanggal Lahir <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <input type="text" name="tanggal_lahir"
                        class="form-control date @error('tanggal_lahir') is-invalid @enderror"
                        value="{{ old('tanggal_lahir') }}"
                        placeholder="YYYY-MM-DD">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">
                    Jenis Kelamin <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <select name="jenis_kelamin"
                        class="form-control @error('jenis_kelamin') is-invalid @enderror">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                            Laki-laki
                        </option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">
                    Alamat Lengkap <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <textarea name="alamat" rows="3"
                        class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Alamat lengkap sesuai Kartu Keluarga">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- DATA ORANG TUA --}}
            <h5 class="mb-3 mt-4 text-muted border-bottom pb-2">
                <i class="fas fa-users mr-1"></i> Data Orang Tua / Wali
            </h5>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">
                    Nama Ortu/Wali <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <input type="text" name="nama_ortu"
                        class="form-control @error('nama_ortu') is-invalid @enderror"
                        value="{{ old('nama_ortu') }}"
                        placeholder="Nama lengkap orang tua / wali">
                    @error('nama_ortu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">
                    No. HP Ortu <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <input type="text" name="no_hp_ortu"
                        class="form-control @error('no_hp_ortu') is-invalid @enderror"
                        value="{{ old('no_hp_ortu') }}"
                        placeholder="08xxxxxxxxxx">
                    @error('no_hp_ortu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

{{-- Ganti seluruh bagian Data Sekolah --}}
<h5 class="mb-3 mt-4 text-muted border-bottom pb-2">
    <i class="fas fa-school mr-1"></i> Data Sekolah
</h5>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Asal Sekolah</label>
    <div class="col-sm-9">
        <input type="text" name="asal_sekolah"
            class="form-control"
            value="{{ old('asal_sekolah') }}"
            placeholder="Nama sekolah asal (opsional)">
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">
        Kelas Tujuan <span class="text-danger">*</span>
    </label>
    <div class="col-sm-9">
        <select name="kelas_tujuan"
            class="form-control @error('kelas_tujuan') is-invalid @enderror">
            <option value="">-- Pilih Kelas --</option>
            <option value="Kelas 1" {{ old('kelas_tujuan') == 'Kelas 1' ? 'selected' : '' }}>Kelas 1</option>
            <option value="Kelas 2" {{ old('kelas_tujuan') == 'Kelas 2' ? 'selected' : '' }}>Kelas 2</option>
            <option value="Kelas 3" {{ old('kelas_tujuan') == 'Kelas 3' ? 'selected' : '' }}>Kelas 3</option>
            <option value="Kelas 4" {{ old('kelas_tujuan') == 'Kelas 4' ? 'selected' : '' }}>Kelas 4</option>
        </select>
        @error('kelas_tujuan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- FIELD BARU: Semester --}}
<div class="form-group row">
    <label class="col-sm-3 col-form-label">
        Semester <span class="text-danger">*</span>
    </label>
    <div class="col-sm-9">
        <select name="semester_id"
            class="form-control @error('semester_id') is-invalid @enderror">
            <option value="">-- Pilih Semester --</option>
            @foreach($semesters as $semester)
                <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                    {{ $semester->tahun_ajaran }} - {{ $semester->semester }}
                </option>
            @endforeach
        </select>
        @error('semester_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
            {{-- UPLOAD DOKUMEN --}}
            <h5 class="mb-3 mt-4 text-muted border-bottom pb-2">
                <i class="fas fa-file-upload mr-1"></i> Upload Dokumen
            </h5>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Foto Calon Siswa</label>
                <div class="col-sm-9">
                    <div class="custom-file">
                        <input type="file" name="foto"
                            class="custom-file-input @error('foto') is-invalid @enderror"
                            accept="image/*" id="inputFoto">
                        <label class="custom-file-label" for="inputFoto">Pilih foto...</label>
                    </div>
                    <small class="text-muted">Format JPG/PNG, maksimal 2MB</small>
                    @error('foto')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Dokumen (Akta/KK)</label>
                <div class="col-sm-9">
                    <div class="custom-file">
                        <input type="file" name="dokumen"
                            class="custom-file-input @error('dokumen') is-invalid @enderror"
                            accept=".pdf,.jpg,.png" id="inputDokumen">
                        <label class="custom-file-label" for="inputDokumen">Pilih dokumen...</label>
                    </div>
                    <small class="text-muted">Format PDF/JPG/PNG, maksimal 4MB</small>
                    @error('dokumen')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- TOMBOL --}}
            <div class="form-group row mt-4">
                <div class="col-sm-9 offset-sm-3">
                    <a href="{{ route('pendaftaran.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary load">
                        <i class="fas fa-save"></i> Simpan Pendaftaran
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    bsCustomFileInput.init();
</script>
@endsection