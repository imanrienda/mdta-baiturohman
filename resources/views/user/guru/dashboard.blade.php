@extends('layouts/master')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

{{-- Semua variable dikirim dari DashboardController@teacher --}}

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Mulish:wght@400;500;600&display=swap');

  /* Scoped ke .db agar tidak bentrok AdminLTE */
  .db { font-family: 'Mulish', sans-serif; }
  .db *, .db *::before, .db *::after { box-sizing: border-box; }

  /* ── Animations ── */
  @keyframes db-fadeUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
  }
  .db-a1 { animation: db-fadeUp .4s ease both; }
  .db-a2 { animation: db-fadeUp .4s .07s ease both; }
  .db-a3 { animation: db-fadeUp .4s .14s ease both; }
  .db-a4 { animation: db-fadeUp .4s .21s ease both; }
  .db-a5 { animation: db-fadeUp .4s .28s ease both; }

  /* ══════════════════
     HERO BANNER
     Warna konsisten: bg-info AdminLTE = #17a2b8
  ══════════════════ */
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
    position:absolute; top:-50px; right:-50px;
    width:220px; height:220px; border-radius:50%;
    border:35px solid rgba(255,255,255,.07);
    pointer-events:none;
  }
  .db-hero::before {
    content:'';
    position:absolute; bottom:-70px; right:70px;
    width:180px; height:180px; border-radius:50%;
    border:28px solid rgba(255,255,255,.04);
    pointer-events:none;
  }

  .db-hero-left  { display:flex; align-items:center; gap:16px; position:relative; z-index:1; }
  .db-hero-right { position:relative; z-index:1; flex-shrink:0; }

  .db-avatar {
    width:58px; height:58px; border-radius:50%;
    border:3px solid rgba(255,255,255,.35);
    overflow:hidden; flex-shrink:0;
    background:rgba(255,255,255,.15);
    display:flex; align-items:center; justify-content:center;
  }
  .db-avatar img { width:100%; height:100%; object-fit:cover; }
  .db-avatar-init {
    font-family:'Plus Jakarta Sans',sans-serif;
    font-size:22px; font-weight:800; color:white;
  }
  .db-greeting { font-size:12.5px; color:rgba(255,255,255,.7); margin-bottom:3px; }
  .db-name {
    font-family:'Plus Jakarta Sans',sans-serif;
    font-size:20px; font-weight:800; color:white; margin-bottom:6px; line-height:1.2;
  }
  .db-chips { display:flex; gap:7px; flex-wrap:wrap; }
  .db-chip {
    background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.2);
    color:white; font-size:11px; font-weight:600;
    padding:3px 9px; border-radius:100px;
  }
  .db-datebox {
    background:rgba(255,255,255,.13); border:1px solid rgba(255,255,255,.2);
    border-radius:10px; padding:12px 18px; text-align:center; color:white;
  }
  .db-datebox .dbd-hari  { font-size:11.5px; font-weight:600; opacity:.8; margin-bottom:2px; }
  .db-datebox .dbd-day   { font-family:'Plus Jakarta Sans',sans-serif; font-size:28px; font-weight:800; line-height:1; }
  .db-datebox .dbd-month { font-size:11.5px; opacity:.7; margin-top:2px; }

  /* ══════════════════
     STAT — pakai small-box AdminLTE style tapi sedikit dimodif
  ══════════════════ */
  .db-stat-row { margin-bottom: 20px; }

  /* ══════════════════
     JADWAL CARD
  ══════════════════ */
  .db-timeline { display:flex; flex-direction:column; gap:10px; }

  .db-sched-item {
    display:flex; align-items:stretch; gap:12px;
    padding:13px 15px; border-radius:8px;
    border:1px solid #dee2e6;
    background:#f8f9fa;
    transition:background .2s, border-color .2s, transform .15s;
  }
  .db-sched-item:hover { background:#e8f4f8; border-color:#17a2b8; transform:translateX(3px); }
  .db-sched-item.active {
    background:#e8f4f8; border-color:#17a2b8;
    box-shadow:0 0 0 3px rgba(23,162,184,.12);
  }

  .db-sched-time {
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    min-width:58px; padding-right:12px;
    border-right:2px dashed #dee2e6;
  }
  .db-sched-time .t-s { font-family:'Plus Jakarta Sans',sans-serif; font-size:14px; font-weight:700; color:#17a2b8; }
  .db-sched-time .t-e { font-size:11px; color:#adb5bd; }

  .db-sched-body { flex:1; min-width:0; }
  .db-sched-kelas {
    font-family:'Plus Jakarta Sans',sans-serif;
    font-size:14px; font-weight:700; color:#212529; margin-bottom:3px;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
  }
  .db-sched-mapel { font-size:12px; color:#6c757d; }

  .db-sched-right {
    display:flex; flex-direction:column;
    align-items:flex-end; justify-content:center;
    gap:5px; flex-shrink:0;
  }
  .db-sched-ruang { font-size:11px; color:#adb5bd; font-weight:600; }

  /* Status badges — konsisten sama warna AdminLTE */
  .dbb { font-size:10px; font-weight:700; padding:2px 8px; border-radius:100px; }
  .dbb-selesai     { background:#d4edda; color:#155724; }
  .dbb-berlangsung { background:#d1ecf1; color:#0c5460; }
  .dbb-akan        { background:#e2e3e5; color:#383d41; }

  .db-empty { text-align:center; padding:32px 16px; color:#adb5bd; }
  .db-empty i    { font-size:36px; display:block; margin-bottom:8px; }
  .db-empty span { font-size:13px; font-weight:600; }

  /* ══════════════════
     PROFIL SIDEBAR
  ══════════════════ */
  .db-prof-top {
    background:linear-gradient(135deg,#17a2b8,#138496);
    height:65px; border-radius:8px 8px 0 0; position:relative;
  }
  .db-prof-avatar {
    position:absolute; left:50%; bottom:-26px;
    transform:translateX(-50%);
    width:54px; height:54px; border-radius:50%;
    border:3px solid #fff; overflow:hidden;
    background:#d1ecf1;
    display:flex; align-items:center; justify-content:center;
  }
  .db-prof-avatar img  { width:100%; height:100%; object-fit:cover; }
  .db-prof-avatar-init {
    font-family:'Plus Jakarta Sans',sans-serif;
    font-size:18px; font-weight:800; color:#17a2b8;
  }
  .db-prof-body  { padding:36px 18px 18px; text-align:center; }
  .db-prof-name  { font-family:'Plus Jakarta Sans',sans-serif; font-size:14.5px; font-weight:700; color:#212529; margin-bottom:2px; }
  .db-prof-nrg   { font-size:11.5px; color:#6c757d; margin-bottom:14px; }

  .db-prof-rows  { text-align:left; }
  .db-prof-row   { display:flex; gap:10px; align-items:flex-start; padding:8px 0; border-bottom:1px solid #dee2e6; font-size:12.5px; }
  .db-prof-row:last-child { border-bottom:none; }
  .db-prof-row i { color:#17a2b8; width:16px; font-size:12px; margin-top:2px; flex-shrink:0; }
  .db-prof-lbl   { color:#adb5bd; font-size:11px; }
  .db-prof-val   { color:#212529; font-weight:600; font-size:12.5px; }

  .db-prof-footer { padding:0 18px 16px; display:flex; gap:8px; }
  .db-prof-btn {
    flex:1; text-align:center; padding:7px 10px;
    border-radius:6px; font-size:12px; font-weight:700;
    text-decoration:none; transition:opacity .2s, transform .15s;
    display:inline-flex; align-items:center; justify-content:center; gap:5px;
  }
  .db-prof-btn:hover { opacity:.88; transform:translateY(-1px); }
  .db-prof-btn.info    { background:#17a2b8; color:white; }
  .db-prof-btn.warning { background:#ffc107; color:#212529; }

  /* Quick links */
  .db-qlink {
    display:flex; align-items:center; gap:10px;
    padding:10px 14px; border-radius:6px;
    background:#f8f9fa; border:1px solid #dee2e6;
    text-decoration:none; color:#212529;
    font-size:13px; font-weight:600; margin-bottom:8px;
    transition:background .2s, border-color .2s, transform .15s;
  }
  .db-qlink:last-child { margin-bottom:0; }
  .db-qlink:hover { background:#e8f4f8; border-color:#17a2b8; color:#17a2b8; transform:translateX(3px); }
  .db-qlink i.ico { width:30px; height:30px; border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:13px; flex-shrink:0; }
  .db-qlink i.ico.info    { background:#d1ecf1; color:#17a2b8; }
  .db-qlink i.ico.success { background:#d4edda; color:#28a745; }
  .db-qlink i.ico.warning { background:#fff3cd; color:#ffc107; }
  .db-qlink .db-qarrow    { margin-left:auto; color:#adb5bd; font-size:11px; }

  /* section title konsisten */
  .db-sec-title {
    font-family:'Plus Jakarta Sans',sans-serif;
    font-size:14.5px; font-weight:700; color:#212529;
    margin-bottom:14px;
    display:flex; align-items:center; gap:8px;
  }
  .db-sec-title::before {
    content:''; display:inline-block;
    width:4px; height:15px; background:#17a2b8; border-radius:4px;
  }

  @media (max-width: 768px) {
    .db-hero { flex-direction:column; align-items:flex-start; }
  }
</style>

<div class="db">

  {{-- ══════════ HERO BANNER ══════════ --}}
  <div class="db-hero db-a1">
    <div class="db-hero-left">
      <div class="db-avatar">
        @if($teacher->getFoto())
          <img src="{{ $teacher->getFoto() }}" alt="{{ $teacher->nama }}">
        @else
          <span class="db-avatar-init">{{ strtoupper(substr($teacher->nama, 0, 1)) }}</span>
        @endif
      </div>
      <div>
        <div class="db-greeting">Selamat datang kembali</div>
        <div class="db-name">{{ $teacher->nama }}</div>
        <div class="db-chips">
          <span class="db-chip"><i class="fas fa-id-card" style="margin-right:4px;font-size:10px;"></i>{{ $teacher->nrg }}</span>
          <span class="db-chip"><i class="fas fa-chalkboard-teacher" style="margin-right:4px;font-size:10px;"></i>Guru</span>
        </div>
      </div>
    </div>
    <div class="db-hero-right">
      <div class="db-datebox">
        <div class="dbd-hari">{{ now()->locale('id')->isoFormat('dddd') }}</div>
        <div class="dbd-day">{{ now()->format('d') }}</div>
        <div class="dbd-month">{{ now()->locale('id')->isoFormat('MMMM YYYY') }}</div>
      </div>
    </div>
  </div>

  {{-- ══════════ STAT CARDS — pakai small-box AdminLTE ══════════ --}}
  <div class="row db-a2">

    <div class="col-lg-4 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $totalSiswa ?? 0 }}</h3>
          <p>Total Siswa</p>
        </div>
        <div class="icon"><i class="fas fa-users"></i></div>
        <a href="homeroom-teacher" class="small-box-footer">Info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-4 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $totalKelas ?? 0 }}</h3>
          <p>Kelas Diajar</p>
        </div>
        <div class="icon"><i class="fas fa-door-open"></i></div>
        <a href="/teacher/schedules" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-4 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $totalJadwal ?? 0 }}</h3>
          <p>Total Jadwal</p>
        </div>
        <div class="icon"><i class="fas fa-calendar-check"></i></div>
        <a href="/teacher/schedules" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>

  </div>

  {{-- ══════════ MAIN GRID ══════════ --}}
  <div class="row">

    {{-- ── JADWAL HARI INI ── --}}
    <div class="col-md-8 db-a3">
      <div class="card">
        <div class="card-header">
          <div class="db-sec-title" style="margin-bottom:0;">
            Jadwal Hari Ini
          </div>
          <div class="card-tools">
            <span style="font-size:12px;color:#adb5bd;font-weight:600;">
              {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
            </span>
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">

          @if($schedules->isNotEmpty())
            <div class="db-timeline">
              @foreach($schedules as $s)
                @php
                  $nowTime = now()->format('H:i');
                  $mulai   = $s->jam_mulai;
                  $selesai = $s->jam_selesai;

                  if ($nowTime >= $mulai && $nowTime <= $selesai) {
                    $stCls  = 'berlangsung';
                    $stLbl  = 'Berlangsung';
                    $badgeCls = 'dbb-berlangsung';
                  } elseif ($nowTime > $selesai) {
                    $stCls  = 'selesai';
                    $stLbl  = 'Selesai';
                    $badgeCls = 'dbb-selesai';
                  } else {
                    $stCls  = 'akan';
                    $stLbl  = 'Akan Datang';
                    $badgeCls = 'dbb-akan';
                  }
                @endphp

                <div class="db-sched-item {{ $stCls === 'berlangsung' ? 'active' : '' }}">
                  <div class="db-sched-time">
                    <span class="t-s">{{ \Carbon\Carbon::parse($s->jam_mulai)->format('H:i') }}</span>
                    <span class="t-e">{{ \Carbon\Carbon::parse($s->jam_selesai)->format('H:i') }}</span>
                  </div>
                  <div class="db-sched-body">
                    <div class="db-sched-kelas">{{ $s->classLearn->classRoom->nama }}</div>
                    <div class="db-sched-mapel">
                      <i class="fas fa-book-open" style="margin-right:4px;color:#17a2b8;font-size:10px;"></i>
                      {{ $s->classLearn->subject->nama }}
                    </div>
                  </div>
                  <div class="db-sched-right">
                    <span class="dbb {{ $badgeCls }}">{{ $stLbl }}</span>
                    <span class="db-sched-ruang">
                      <i class="fas fa-map-marker-alt" style="margin-right:3px;"></i>{{ $s->classLearn->classRoom->nama }}
                    </span>
                  </div>
                </div>
              @endforeach
            </div>

            <div class="mt-3">
              <a href="/teacher/schedules" class="btn btn-info btn-sm">
                <i class="fas fa-calendar-alt"></i> Lihat Semua Jadwal
              </a>
            </div>

          @else
            <div class="db-empty">
              <i class="fas fa-calendar-times"></i>
              <span>Tidak ada jadwal mengajar hari ini</span>
            </div>
            <div class="text-center mt-2">
              <a href="/teacher/schedules" class="btn btn-info btn-sm">
                <i class="fas fa-calendar-alt"></i> Cek Jadwal Lengkap
              </a>
            </div>
          @endif

        </div>
      </div>
    </div>

    {{-- ── RIGHT SIDEBAR ── --}}
    <div class="col-md-4 db-a4">

      {{-- Profil Card --}}
      <div class="card" style="overflow:hidden;">
        <div class="db-prof-top">
          <div class="db-prof-avatar">
            @if($teacher->getFoto())
              <img src="{{ $teacher->getFoto() }}" alt="{{ $teacher->nama }}">
            @else
              <span class="db-prof-avatar-init">{{ strtoupper(substr($teacher->nama, 0, 1)) }}</span>
            @endif
          </div>
        </div>
        <div class="db-prof-body">
          <div class="db-prof-name">{{ $teacher->nama }}</div>
          <div class="db-prof-nrg">NRG: {{ $teacher->nrg }}</div>
          <div class="db-prof-rows">
            <div class="db-prof-row">
              <i class="fas fa-map-marker-alt"></i>
              <div>
                <div class="db-prof-lbl">Tempat Lahir</div>
                <div class="db-prof-val">{{ $teacher->tempat_lahir ?? '-' }}</div>
              </div>
            </div>
            <div class="db-prof-row">
              <i class="fas fa-venus-mars"></i>
              <div>
                <div class="db-prof-lbl">Jenis Kelamin</div>
                <div class="db-prof-val">{{ $teacher->jenis_kelamin ?? '-' }}</div>
              </div>
            </div>
            <div class="db-prof-row">
              <i class="fas fa-envelope"></i>
              <div>
                <div class="db-prof-lbl">Email</div>
                <div class="db-prof-val" style="word-break:break-all;">{{ $teacher->user->email ?? '-' }}</div>
              </div>
            </div>
            <div class="db-prof-row">
              <i class="fas fa-phone"></i>
              <div>
                <div class="db-prof-lbl">No. Telepon</div>
                <div class="db-prof-val">{{ $teacher->telp ?? '-' }}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="db-prof-footer">
          <a href="/teacher/profile" class="db-prof-btn info">
            <i class="fas fa-user"></i> Profil
          </a>
          <a href="/teacher/edit-profile" class="db-prof-btn warning">
            <i class="fas fa-pen"></i> Edit
          </a>
        </div>
      </div>

      {{-- Quick Links --}}
      <div class="card db-a5">
        <div class="card-header">
          <div class="db-sec-title" style="margin-bottom:0;">Menu Cepat</div>
        </div>
        <div class="card-body" style="padding:14px 16px;">
          <a href="/teacher/schedules" class="db-qlink">
            <i class="fas fa-calendar-alt ico info"></i>
            Jadwal Mengajar
            <span class="db-qarrow"><i class="fas fa-chevron-right"></i></span>
          </a>
          <a href="/teacher/grades" class="db-qlink">
            <i class="fas fa-star-half-alt ico success"></i>
            Input Nilai
            <span class="db-qarrow"><i class="fas fa-chevron-right"></i></span>
          </a>
          <a href="/teacher/profile" class="db-qlink">
            <i class="fas fa-user-circle ico info"></i>
            Profil Saya
            <span class="db-qarrow"><i class="fas fa-chevron-right"></i></span>
          </a>
          <a href="/teacher/changePassword" class="db-qlink">
            <i class="fas fa-key ico warning"></i>
            Ganti Password
            <span class="db-qarrow"><i class="fas fa-chevron-right"></i></span>
          </a>
        </div>
      </div>

    </div>
  </div>

</div>

@endsection