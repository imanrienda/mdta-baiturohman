@extends('layouts.master')

@section('title', 'Detail Pendaftaran')
@section('header', 'Detail Pendaftaran Siswa')

@section('style')
<style>
    @media print {
        .no-print { display: none !important; }
        .main-sidebar,
        .main-header,
        .main-footer,
        .content-header { display: none !important; }
        .content-wrapper {
            margin-left: 0 !important;
            padding-top: 0 !important;
        }
        .card { box-shadow: none !important; border: 1px solid #ddd; }
    }
</style>
@endsection

@section('content')

{{-- Tombol Aksi --}}
<div class="mb-3 no-print">
    <a href="{{ route('pendaftaran.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <button onclick="window.print()" class="btn btn-primary">
        <i class="fas fa-print"></i> Cetak Bukti
    </button>
</div>

<div class="card">
    <div class="card-header text-center bg-dark text-white">
        <h4 class="mb-0">DETAIL PENDAFTARAN SISWA BARU</h4>
        <small>No. Pendaftaran: <strong>#{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}</strong></small>
    </div>

    <div class="card-body">

        {{-- Badge Status --}}
        <div class="text-center mb-4">
            @if($data->status == 'pending')
                <span class="badge badge-warning px-3 py-2" style="font-size:15px">
                    <i class="fas fa-clock"></i> PENDING
                </span>
            @elseif($data->status == 'diterima')
                <span class="badge badge-success px-3 py-2" style="font-size:15px">
                    <i class="fas fa-check-circle"></i> DITERIMA
                </span>
            @else
                <span class="badge badge-danger px-3 py-2" style="font-size:15px">
                    <i class="fas fa-times-circle"></i> DITOLAK
                </span>
            @endif
        </div>

        <div class="row">
            {{-- Foto Siswa --}}
            <div class="col-md-2 text-center mb-3">
                @if($data->foto)
                    <img src="{{ asset('storage/' . $data->foto) }}"
                         class="img-fluid rounded border"
                         style="max-height:150px; max-width:150px"
                         alt="Foto Siswa">
                @else
                    <div class="bg-light border rounded d-flex align-items-center
                                justify-content-center"
                         style="height:150px; width:150px; margin:auto">
                        <span class="text-muted small">Tidak ada foto</span>
                    </div>
                @endif
            </div>

            {{-- Data Siswa --}}
            <div class="col-md-10">
                <h5 class="border-bottom pb-2 mb-3">
                    <i class="fas fa-user mr-1"></i> Data Calon Siswa
                </h5>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="35%"><strong>Nama Lengkap</strong></td>
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
                <td width="35%"><strong>Nama Ortu/Wali</strong></td>
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
                <td width="35%"><strong>Asal Sekolah</strong></td>
                <td>: {{ $data->asal_sekolah ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Kelas Tujuan</strong></td>
                <td>: {{ $data->kelas_tujuan }}</td>
            </tr>
            <tr>
                <td><strong>Dokumen</strong></td>
                <td>:
                    @if($data->dokumen)
                        <a href="{{ asset('storage/' . $data->dokumen) }}"
                           target="_blank" class="btn btn-outline-secondary btn-sm no-print">
                            <i class="fas fa-file"></i> Lihat Dokumen
                        </a>
                        <span class="d-none d-print-inline">Terlampir</span>
                    @else
                        <span class="text-muted">Tidak ada</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Tanggal Daftar</strong></td>
                <td>: {{ $data->created_at->format('d F Y, H:i') }} WIB</td>
            </tr>
        </table>

        <hr>

        {{-- Tombol Approve / Tolak --}}
        @if($data->status == 'pending')
        <div class="text-center mt-3 no-print">
            <form action="{{ route('pendaftaran.status', $data->id) }}"
                  method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="diterima">
                <button type="submit" class="btn btn-success btn-lg"
                        onclick="return confirm('Yakin ingin menerima pendaftaran ini?')">
                    <i class="fas fa-check-circle"></i> Terima Pendaftaran
                </button>
            </form>
            <form action="{{ route('pendaftaran.status', $data->id) }}"
                  method="POST" class="d-inline ml-2">
                @csrf
                <input type="hidden" name="status" value="ditolak">
                <button type="submit" class="btn btn-danger btn-lg"
                        onclick="return confirm('Yakin ingin menolak pendaftaran ini?')">
                    <i class="fas fa-times-circle"></i> Tolak Pendaftaran
                </button>
            </form>
        </div>
        @endif

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