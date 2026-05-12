@extends('layouts/master')

@section('title', 'Detail Pengumuman')
@section('header', 'Detail Pengumuman')

@section('content')

{{-- Tombol kembali ke halaman semua pengumuman --}}
<a href="/student/dashboard/informations" class="btn btn-info btn-sm mb-3">
    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Semua Pengumuman
</a>

<div class="row">
    <div class="col-md-12">
        <div class="callout callout-info">
            <h5>{{ $information->judul }}</h5>
            <span class="mailbox-read-time">
                <i class="fas fa-clock mr-1"></i>
                {{ $information->created_at->format('d M Y') }}
            </span>
            <hr>
            <div>{!! $information->konten !!}</div>
        </div>
    </div>
</div>

@endsection