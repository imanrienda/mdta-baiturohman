@extends('layouts/master')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Mulish:wght@400;500;600&display=swap');

  .db { font-family: 'Mulish', sans-serif; }
  .db *, .db *::before, .db *::after { box-sizing: border-box; }

  @keyframes db-fadeUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
  }

  .db-a1 { animation: db-fadeUp .4s ease both; }
  .db-a2 { animation: db-fadeUp .4s .07s ease both; }
  .db-a3 { animation: db-fadeUp .4s .14s ease both; }
  .db-a4 { animation: db-fadeUp .4s .21s ease both; }
  .db-a5 { animation: db-fadeUp .4s .28s ease both; }

  .db-hero {
    background: linear-gradient(120deg, #138496 0%, #17a2b8 55%, #1c6ea4 100%);
    border-radius: 8px;
    padding: 24px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(23,162,184,.3);
  }

  .db-hero::after {
    content:'';
    position:absolute;
    top:-50px;
    right:-50px;
    width:220px;
    height:220px;
    border-radius:50%;
    border:35px solid rgba(255,255,255,.07);
  }

  .db-hero::before {
    content:'';
    position:absolute;
    bottom:-70px;
    right:70px;
    width:180px;
    height:180px;
    border-radius:50%;
    border:28px solid rgba(255,255,255,.04);
  }

  .db-hero-left {
    display:flex;
    align-items:center;
    gap:16px;
    position:relative;
    z-index:1;
  }

  .db-avatar {
    width:58px;
    height:58px;
    border-radius:50%;
    border:3px solid rgba(255,255,255,.35);
    overflow:hidden;
    background:rgba(255,255,255,.15);
    display:flex;
    align-items:center;
    justify-content:center;
  }

  .db-avatar img {
    width:100%;
    height:100%;
    object-fit:cover;
  }

  .db-avatar-init {
    font-size:22px;
    font-weight:800;
    color:white;
  }

  .db-greeting {
    font-size:12.5px;
    color:rgba(255,255,255,.7);
    margin-bottom:3px;
  }

  .db-name {
    font-size:20px;
    font-weight:800;
    color:white;
    margin-bottom:6px;
  }

  .db-chips {
    display:flex;
    gap:7px;
    flex-wrap:wrap;
  }

  .db-chip {
    background:rgba(255,255,255,.15);
    border:1px solid rgba(255,255,255,.2);
    color:white;
    font-size:11px;
    font-weight:600;
    padding:3px 9px;
    border-radius:100px;
  }

  .db-datebox {
    background:rgba(255,255,255,.13);
    border:1px solid rgba(255,255,255,.2);
    border-radius:10px;
    padding:12px 18px;
    text-align:center;
    color:white;
    position:relative;
    z-index:1;
  }

  .dbd-hari {
    font-size:11.5px;
    font-weight:600;
    opacity:.8;
  }

  .dbd-day {
    font-size:28px;
    font-weight:800;
    line-height:1;
  }

  .dbd-month {
    font-size:11.5px;
    opacity:.7;
  }

  .db-timeline {
    display:flex;
    flex-direction:column;
    gap:10px;
  }

  .db-sched-item {
    display:flex;
    align-items:stretch;
    gap:12px;
    padding:13px 15px;
    border-radius:8px;
    border:1px solid #dee2e6;
    background:#f8f9fa;
    transition:.2s;
  }

  .db-sched-item:hover {
    background:#e8f4f8;
    border-color:#17a2b8;
  }

  .db-sched-item.active {
    background:#e8f4f8;
    border-color:#17a2b8;
    box-shadow:0 0 0 3px rgba(23,162,184,.12);
  }

  .db-sched-time {
    min-width:58px;
    border-right:2px dashed #dee2e6;
    padding-right:12px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
  }

  .db-sched-time .t-s {
    font-size:14px;
    font-weight:700;
    color:#17a2b8;
  }

  .db-sched-time .t-e {
    font-size:11px;
    color:#adb5bd;
  }

  .db-sched-body {
    flex:1;
  }

  .db-sched-kelas {
    font-size:14px;
    font-weight:700;
    color:#212529;
    margin-bottom:3px;
  }

  .db-sched-mapel {
    font-size:12px;
    color:#6c757d;
  }

  .db-sched-right {
    display:flex;
    flex-direction:column;
    align-items:flex-end;
    justify-content:center;
    gap:5px;
  }

  .dbb {
    font-size:10px;
    font-weight:700;
    padding:2px 8px;
    border-radius:100px;
  }

  .dbb-selesai {
    background:#d4edda;
    color:#155724;
  }

  .dbb-berlangsung {
    background:#d1ecf1;
    color:#0c5460;
  }

  .dbb-akan {
    background:#e2e3e5;
    color:#383d41;
  }

  .db-empty {
    text-align:center;
    padding:32px 16px;
    color:#adb5bd;
  }

  .db-sec-title {
    font-size:14.5px;
    font-weight:700;
    color:#212529;
    display:flex;
    align-items:center;
    gap:8px;
  }

  .db-sec-title::before {
    content:'';
    width:4px;
    height:15px;
    background:#17a2b8;
    border-radius:4px;
  }

  @media (max-width:768px){
    .db-hero {
      flex-direction:column;
      align-items:flex-start;
    }
  }
</style>

<div class="db">

  {{-- HERO --}}
  <div class="db-hero db-a1">

    <div class="db-hero-left">

      <div class="db-avatar">
        @if($teacher->getFoto())
          <img src="{{ $teacher->getFoto() }}" alt="{{ $teacher->nama }}">
        @else
          <span class="db-avatar-init">
            {{ strtoupper(substr($teacher->nama, 0, 1)) }}
          </span>
        @endif
      </div>

      <div>
        <div class="db-greeting">
          Selamat datang kembali
        </div>

        <div class="db-name">
          {{ $teacher->nama }}
        </div>

        <div class="db-chips">

          <span class="db-chip">
            <i class="fas fa-id-card"></i>
            {{ $teacher->nrg }}
          </span>

          <span class="db-chip">
            <i class="fas fa-chalkboard-teacher"></i>
            Guru
          </span>

        </div>
      </div>

    </div>

    <div class="db-datebox">
      <div class="dbd-hari">
        {{ now()->locale('id')->isoFormat('dddd') }}
      </div>

      <div class="dbd-day">
        {{ now()->format('d') }}
      </div>

      <div class="dbd-month">
        {{ now()->locale('id')->isoFormat('MMMM YYYY') }}
      </div>
    </div>

  </div>

  {{-- STAT --}}
  <div class="row db-a2">

    <div class="col-lg-4 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $totalSiswa ?? 0 }}</h3>
          <p>Total Siswa</p>
        </div>
        <div class="icon">
          <i class="fas fa-users"></i>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $totalKelas ?? 0 }}</h3>
          <p>Kelas Diajar</p>
        </div>
        <div class="icon">
          <i class="fas fa-door-open"></i>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $totalJadwal ?? 0 }}</h3>
          <p>Total Jadwal</p>
        </div>
        <div class="icon">
          <i class="fas fa-calendar-check"></i>
        </div>
      </div>
    </div>

  </div>

  {{-- MAIN --}}
  <div class="row">

    <div class="col-md-8 db-a3">

      <div class="card">

        <div class="card-header">

          <div class="db-sec-title">
            Jadwal Hari Ini
          </div>

        </div>

        <div class="card-body">

          @if($schedules->isNotEmpty())

            <div class="db-timeline">

              @foreach($schedules as $s)

              @php

                // ===================================
                // FIX RELASI BARU
                // ===================================

                $namaKelas = $s->classRoom->nama ?? '-';
                $namaMapel = $s->subject->nama ?? '-';

                $nowTime = now()->format('H:i');
                $mulai   = $s->jam_mulai;
                $selesai = $s->jam_selesai;

                if ($nowTime >= $mulai && $nowTime <= $selesai) {

                  $stCls    = 'berlangsung';
                  $stLbl    = 'Berlangsung';
                  $badgeCls = 'dbb-berlangsung';

                } elseif ($nowTime > $selesai) {

                  $stCls    = 'selesai';
                  $stLbl    = 'Selesai';
                  $badgeCls = 'dbb-selesai';

                } else {

                  $stCls    = 'akan';
                  $stLbl    = 'Akan Datang';
                  $badgeCls = 'dbb-akan';

                }

              @endphp

              <div class="db-sched-item {{ $stCls == 'berlangsung' ? 'active' : '' }}">

                <div class="db-sched-time">
                  <span class="t-s">
                    {{ \Carbon\Carbon::parse($s->jam_mulai)->format('H:i') }}
                  </span>

                  <span class="t-e">
                    {{ \Carbon\Carbon::parse($s->jam_selesai)->format('H:i') }}
                  </span>
                </div>

                <div class="db-sched-body">

                  <div class="db-sched-kelas">
                    {{ $namaKelas }}
                  </div>

                  <div class="db-sched-mapel">
                    <i class="fas fa-book-open"></i>
                    {{ $namaMapel }}
                  </div>

                </div>

                <div class="db-sched-right">

                  <span class="dbb {{ $badgeCls }}">
                    {{ $stLbl }}
                  </span>

                  <span class="db-sched-ruang">
                    {{ $namaKelas }}
                  </span>

                </div>

              </div>

              @endforeach

            </div>

          @else

            <div class="db-empty">
              <i class="fas fa-calendar-times"></i>
              <br>
              Tidak ada jadwal mengajar hari ini
            </div>

          @endif

        </div>

      </div>

    </div>

  </div>

</div>

@endsection