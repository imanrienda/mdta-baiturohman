@extends('layouts/master')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')

{{-- ===== PENGUMUMAN ===== --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pengumuman</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
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
                            {!! Str::limit(strip_tags($info->konten), 80) !!}
                        </span>
                    </div>
                </li>
            @empty
                <li class="item">
                    <div class="ml-4 py-2 text-muted">
                        <i class="fas fa-info-circle mr-1"></i> Belum ada pengumuman.
                    </div>
                </li>
            @endforelse
        </ul>
    </div>

    <div class="card-footer text-center">
        {{-- ✅ PERBAIKAN: arahkan ke halaman semua pengumuman --}}
        <a href="/student/dashboard/informations" class="uppercase">
            Lihat Semua
        </a>
    </div>
</div>

{{-- ===== CHART NILAI ===== --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Grafik Nilai Rata-rata</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        @if(count($semester) > 0)
            <div id="chartSiswa" style="width:100%; height:400px;"></div>
        @else
            <p class="text-muted text-center py-4">
                <i class="fas fa-chart-line mr-1"></i> Data nilai belum tersedia.
            </p>
        @endif
    </div>
</div>

@endsection


@section('script')
<script src="https://cdn.jsdelivr.net/npm/highcharts@11/highcharts.js"></script>

@if(count($semester) > 0)
<script>
    Highcharts.chart('chartSiswa', {
        chart: { type: 'spline' },
        title: { text: 'Nilai Rata-rata per Semester' },
        xAxis: {
            categories: {!! json_encode($semester) !!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            max: 100,
            title: { text: 'Nilai' }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{point.key}</span><br>',
            pointFormat: '<b>Rata-rata: {point.y:.2f}</b>'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                label: { connectorAllowed: false },
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },
        series: [{
            name: 'Nilai Rata-rata',
            data: {!! json_encode($rata2) !!}
        }],
        responsive: {
            rules: [{
                condition: { maxWidth: 500 },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        },
        credits: { enabled: false }
    });
</script>
@endif

@endsection