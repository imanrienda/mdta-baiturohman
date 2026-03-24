@extends('layouts.public')

@section('title', 'Bukti Pendaftaran')

@section('style')
<style>
    @media print {
        .brand-header, .no-print { display: none !important; }
        body { background: white; }
        .card { box-shadow: none !important; border: 1px solid #ddd; }
    }
</style>
@endsection

@section('content')

<div class="mb-3 no-print">
    <button onclick="window.print()" class="btn btn-primary">
        <i class="fas fa-print"></i> Cetak Bukti Pendaftaran
    </button>
    <a href="{{ url('/daftar') }}" class="btn btn-secondary">
        <i class="fas fa-plus"></i> Daftar Lagi
    </a>
</div>

<div class="card">
    <div class="card-header text-center bg-dark text-white">
        <h4 class="mb-0">BUKTI PENDAFTARAN SISWA BARU</h4>
        <small>No. Pendaftaran: <strong>#{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}</strong></small>
    </div>

    <div class="card-body">

        {{-- Alert sukses --}}
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        </div>
        @endif

        {{-- Badge Status --}}
        <div class="text-center mb-4">
            @if($data->status == 'pending')
                <span class="badge badge-warning px-3 py-2" style="font-size:15px">
                    <i class="fas fa-clock"></i> MENUNGGU VERIFIKASI
                </span>
                <p class="text-muted mt-2 small">
                    Data Anda sudah diterima, mohon tunggu konfirmasi dari pihak sekolah.
                </p>
            @elseif($data->status == 'diterima')
                <span class="badge badge-success px-3 py-2" style="font-size:15px">
                    <i class="fas fa-check-circle"></i> DITERIMA
                </span>
                <p class="text-success mt-2 small">
                    Selamat! Pendaftaran Anda telah diterima.
                </p>
            @else
                <span class="badge badge-danger px-3 py-2" style="font-size:15px">
                    <i class="fas fa-times-circle"></i> DITOLAK
                </span>
                <p class="text-danger mt-2 small">
                    Mohon maaf, pendaftaran Anda tidak dapat diterima.
                </p>
            @endif
        </div>

        <div class="row">
            {{-- Foto Siswa --}}
            <div class="col-md-3 text-center mb-3">
                @if($data->foto)
                    <img src="{{ asset('storage/' . $data->foto) }}"
                         class="img-fluid rounded border"
                         style="max-height:150px; max-width:150px"
                         alt="Foto Siswa">
                @else
                    <div class="bg-light border rounded d-flex align-items-center
                                justify-content-center mx-auto"
                         style="height:150px; width:150px;">
                        <span class="text-muted small">Tidak ada foto</span>
                    </div>
                @endif
            </div>

            {{-- Data Siswa --}}
            <div class="col-md-9">
                <h5 class="border-bottom pb-2 mb-3">
                    <i class="fas fa-user mr-1"></i> Data Calon Siswa
                </h5>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="40%"><strong>Nama Lengkap</strong></td>
                        <td>: {{ $data->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>NISN</strong></td>
                        <td>: {{ $data->nisn ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tempat, Tgl Lahir</strong></td>
                        <td>: {{ $data->tempat_lahir }},
                            {{ \Carbon\Carbon::parse($data->tanggal_lahir)->format('d F Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Kelamin</strong></td>
                        <td>: {{ $data->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>: {{ $data->alamat }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <h5 class="border-bottom pb-2 mb-3">
            <i class="fas fa-users mr-1"></i> Data Orang Tua / Wali
        </h5>
        <table class="table table-sm table-borderless">
            <tr>
                <td width="40%"><strong>Nama Ortu/Wali</strong></td>
                <td>: {{ $data->nama_ortu }}</td>
            </tr>
            <tr>
                <td><strong>No. HP</strong></td>
                <td>: {{ $data->no_hp_ortu }}</td>
            </tr>
        </table>

        <hr>

        <h5 class="border-bottom pb-2 mb-3">
            <i class="fas fa-school mr-1"></i> Data Sekolah
        </h5>
        <table class="table table-sm table-borderless">
            <tr>
                <td width="40%"><strong>Asal Sekolah</strong></td>
                <td>: {{ $data->asal_sekolah ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Kelas Tujuan</strong></td>
                <td>: {{ $data->kelas_tujuan }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Daftar</strong></td>
                <td>: {{ $data->created_at->format('d F Y, H:i') }} WIB</td>
            </tr>
        </table>

        <hr>

        {{-- Tanda Tangan --}}
        <div class="row mt-4 mb-2">
            <div class="col-md-6 text-center">
                <p>Orang Tua / Wali</p>
                <br><br><br>
                <p><strong>{{ $data->nama_ortu }}</strong></p>
            </div>
            <div class="col-md-6 text-center">
                <p>Petugas Pendaftaran</p>
                <br><br><br>
                <p><strong>(______________________)</strong></p>
            </div>
        </div>

    </div>
</div>
@endsection