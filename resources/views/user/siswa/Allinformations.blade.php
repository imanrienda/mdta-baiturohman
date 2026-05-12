@extends('layouts/master')

@section('title', 'Semua Pengumuman')
@section('header', 'Semua Pengumuman')

@section('content')

<a href="/student/dashboard" class="btn btn-info btn-sm mb-3">
    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
</a>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pengumuman</h3>
    </div>

    <div class="card-body p-0">
        <ul class="products-list product-list-in-card">
            @forelse ($informations as $info)
                <li class="item">
                    <div class="ml-4">
                        <a href="/student/dashboard/information/{{ $info->id }}" class="product-title">
                            {{ $info->judul }}
                        </a>
                        <span class="product-description">
                            {!! Str::limit(strip_tags($info->konten), 100) !!}
                        </span>
                        <span class="text-muted" style="font-size:11px;">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $info->created_at->format('d M Y') }}
                        </span>
                    </div>
                </li>
            @empty
                <li class="item">
                    <div class="ml-4 py-3 text-muted">
                        <i class="fas fa-info-circle mr-1"></i> Belum ada pengumuman.
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
</div>

@endsection