@extends('layouts/master')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ totalSiswa() }}</h3>
                <p>Siswa</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="/students" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ totalGuru() }}</h3>
                <p>Guru</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="/teachers" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ totalAdmin() }}</h3>
                <p>Admin</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="/admins" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ totalKelas() }}</h3>
                <p>Kelas</p>
            </div>
            <div class="icon">
                <i class="fas fa-school"></i>
            </div>
            <a href="/class-rooms" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Jenis Kelamin Siswa</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div id="siswa"></div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Jenis Kelamin Guru</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div id="guru"></div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    // Chart Jenis Kelamin Siswa
    Highcharts.chart('siswa', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        title: {
            text: 'Jenis Kelamin<br>Siswa<br>',
            align: 'center',
            verticalAlign: 'middle',
            y: 60
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.z:.0f} orang)'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    distance: -45,
                    format: '<b>{point.name}</b><br>{point.percentage:.1f}%',
                    style: {
                        fontWeight: 'bold',
                        color: 'white',
                        textOutline: 'none',
                        fontSize: '13px'
                    }
                },
                showInLegend: true,
                startAngle: -90,
                endAngle: 90,
                center: ['50%', '75%'],
                size: '110%'
            }
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom'
        },
        series: [{
            type: 'pie',
            name: 'Persentase',
            innerSize: '50%',
            data: [
                {
                    name: 'Laki-Laki',
                    y: {!! json_encode($lakiLaki) !!},
                    z: {!! json_encode($lakiLaki) !!},
                },
                {
                    name: 'Perempuan',
                    y: {!! json_encode($perempuan) !!},
                    z: {!! json_encode($perempuan) !!},
                }
            ]
        }]
    });

    // Chart Jenis Kelamin Guru
    Highcharts.chart('guru', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        title: {
            text: 'Jenis Kelamin<br>Guru<br>',
            align: 'center',
            verticalAlign: 'middle',
            y: 60
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.z:.0f} orang)'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    distance: -45,
                    format: '<b>{point.name}</b><br>{point.percentage:.1f}%',
                    style: {
                        fontWeight: 'bold',
                        color: 'white',
                        textOutline: 'none',
                        fontSize: '13px'
                    }
                },
                showInLegend: true,
                startAngle: -90,
                endAngle: 90,
                center: ['50%', '75%'],
                size: '110%'
            }
        },
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom'
        },
        series: [{
            type: 'pie',
            name: 'Persentase',
            innerSize: '50%',
            data: [
                {
                    name: 'Laki-Laki',
                    y: {!! json_encode($guruLakiLaki) !!},
                    z: {!! json_encode($guruLakiLaki) !!},
                },
                {
                    name: 'Perempuan',
                    y: {!! json_encode($guruPerempuan) !!},
                    z: {!! json_encode($guruPerempuan) !!},
                }
            ]
        }]
    });
</script>
@endsection