@extends('layouts.master')

@section('title', 'Data Pendaftaran')
@section('header', 'Data Pendaftaran Siswa')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Data Pendaftaran</h3>
        <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Manual
        </a>
    </div>
    <div class="card-body">
        <table id="tbl-pendaftaran" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NISN</th>
                    <th>Kelas Tujuan</th>
                    <th>Asal Sekolah</th>
                    <th>No. HP Ortu</th>
                    <th>Status</th>
                    <th>Tgl Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->nisn ?? '-' }}</td>
                    <td>{{ $item->kelas_tujuan }}</td>
                    <td>{{ $item->asal_sekolah ?? '-' }}</td>
                    <td>{{ $item->no_hp_ortu }}</td>
                    <td>
                        @if($item->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($item->status == 'diterima')
                            <span class="badge badge-success">Diterima</span>
                        @else
                            <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('pendaftaran.show', $item->id) }}"
                           class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>

                        @if($item->status == 'pending')
                        <form action="{{ route('pendaftaran.status', $item->id) }}"
                              method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="status" value="diterima">
                            <button type="submit" class="btn btn-success btn-sm"
                                    onclick="return confirm('Terima pendaftaran ini?')">
                                <i class="fas fa-check"></i> Terima
                            </button>
                        </form>
                        <form action="{{ route('pendaftaran.status', $item->id) }}"
                              method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="status" value="ditolak">
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Tolak pendaftaran ini?')">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-3">
                        Belum ada data pendaftaran
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#tbl-pendaftaran').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
            emptyTable: "Tidak ada data tersedia"
        }
    });
</script>
@endsection