<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EduSys — Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Mulish:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary:       #17a2b8;
      --primary-dark:  #138496;
      --primary-deep:  #0f6674;
      --primary-light: #d1ecf1;
      --primary-bg:    #f0f9fb;
      --accent:        #1c6ea4;
      --text-dark:     #0F172A;
      --text-mid:      #475569;
      --text-light:    #94A3B8;
      --border:        #E2E8F0;
      --white:         #FFFFFF;
      --bg:            #eaf6f8;
      --error:         #EF4444;
      --card-shadow:   0 20px 60px rgba(23,162,184,0.15), 0 4px 16px rgba(0,0,0,0.06);
    }

    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

    body {
      font-family: 'Mulish', sans-serif;
      background-color: var(--bg);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }

    /* Animated background blobs */
    .bg-blob {
      position: fixed; border-radius: 50%;
      filter: blur(80px); opacity: 0.4;
      animation: floatBlob 8s ease-in-out infinite;
      z-index: 0; pointer-events: none;
    }
    .bg-blob-1 {
      width:500px; height:500px;
      background: radial-gradient(circle, #81d4fa, #17a2b8);
      top:-150px; right:-100px; animation-delay:0s;
    }
    .bg-blob-2 {
      width:400px; height:400px;
      background: radial-gradient(circle, #b2ebf2, #0097a7);
      bottom:-100px; left:-100px; animation-delay:-3s;
    }
    .bg-blob-3 {
      width:300px; height:300px;
      background: radial-gradient(circle, #e0f7fa, #26c6da);
      bottom:100px; right:150px; animation-delay:-5s;
    }
    @keyframes floatBlob {
      0%,100% { transform:translate(0,0) scale(1); }
      33%      { transform:translate(20px,-20px) scale(1.04); }
      66%      { transform:translate(-15px,15px) scale(0.97); }
    }

    /* Grid pattern */
    body::before {
      content:''; position:fixed; inset:0;
      background-image:
        linear-gradient(rgba(23,162,184,0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(23,162,184,0.05) 1px, transparent 1px);
      background-size:40px 40px; z-index:0;
    }

    /* Main wrapper */
    .login-wrapper {
      position:relative; z-index:1;
      display:flex; width:100%; max-width:960px; min-height:560px;
      margin:24px; border-radius:20px; overflow:hidden;
      box-shadow:var(--card-shadow);
      animation: slideUp .6s cubic-bezier(.16,1,.3,1) both;
    }
    @keyframes slideUp {
      from { opacity:0; transform:translateY(32px); }
      to   { opacity:1; transform:translateY(0); }
    }

    /* LEFT PANEL */
    .panel-left {
      flex:1;
      background: linear-gradient(145deg, var(--primary-deep) 0%, var(--primary-dark) 40%, var(--accent) 100%);
      padding:48px 44px;
      display:flex; flex-direction:column; justify-content:space-between;
      position:relative; overflow:hidden;
    }
    .panel-left::before {
      content:''; position:absolute; inset:0;
      background: url("data:image/svg+xml,%3Csvg width='400' height='400' viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='200' cy='200' r='180' stroke='rgba(255,255,255,0.06)' fill='none' stroke-width='1'/%3E%3Ccircle cx='200' cy='200' r='130' stroke='rgba(255,255,255,0.05)' fill='none' stroke-width='1'/%3E%3Ccircle cx='200' cy='200' r='80' stroke='rgba(255,255,255,0.05)' fill='none' stroke-width='1'/%3E%3C/svg%3E") center/cover no-repeat;
      opacity:.6;
    }
    .panel-left-content { position:relative; z-index:1; }

    /* Brand / Logo */
    .brand { display:flex; align-items:center; gap:16px; margin-bottom:48px; }
.brand-logo {
  width:100px; height:100px;
  border-radius:18px;
  object-fit:contain;
  background:white;
  padding:8px;
  border:3px solid rgba(255,255,255,.6);
  box-shadow: 0 8px 32px rgba(0,0,0,0.35);
}
.brand-logo-placeholder {
  width:100px; height:100px; border-radius:18px;
  background:rgba(255,255,255,.15); border:3px solid rgba(255,255,255,.25);
  display:flex; align-items:center; justify-content:center;
  color:white; font-size:32px;
  font-family:'Plus Jakarta Sans',sans-serif; font-weight:800;
}
.brand-name {
  font-family:'Plus Jakarta Sans',sans-serif;
  font-size:28px; font-weight:800; color:white; letter-spacing:-.5px;
}
.brand-name span { opacity:.7; font-weight:400; }

    .panel-headline {
      font-family:'Plus Jakarta Sans',sans-serif;
      font-size:30px; font-weight:800; color:white;
      line-height:1.25; letter-spacing:-.5px; margin-bottom:14px;
    }
    .panel-sub {
      font-size:14.5px; color:rgba(255,255,255,.7);
      line-height:1.65; max-width:280px;
    }

    /* Stats row */
    .stats-row { display:flex; gap:14px; position:relative; z-index:1; }
    .stat-item {
      background:rgba(255,255,255,.12);
      backdrop-filter:blur(10px);
      border:1px solid rgba(255,255,255,.18);
      border-radius:12px; padding:14px 18px; flex:1;
      transition:background .2s;
    }
    .stat-item:hover { background:rgba(255,255,255,.18); }
    .stat-num {
      font-family:'Plus Jakarta Sans',sans-serif;
      font-size:22px; font-weight:800; color:white;
    }
    .stat-label { font-size:11.5px; color:rgba(255,255,255,.6); margin-top:2px; }

    /* RIGHT PANEL */
    .panel-right {
      width:420px; background:var(--white);
      padding:52px 44px;
      display:flex; flex-direction:column; justify-content:center;
    }

    .form-header { margin-bottom:32px; }

    .form-tag {
      display:inline-flex; align-items:center; gap:6px;
      background:var(--primary-light); color:var(--primary-dark);
      font-size:11.5px; font-weight:700;
      padding:4px 12px; border-radius:100px; margin-bottom:14px; letter-spacing:.3px;
    }
    .form-tag::before {
      content:''; width:6px; height:6px;
      background:var(--primary); border-radius:50%;
    }
    .form-title {
      font-family:'Plus Jakarta Sans',sans-serif;
      font-size:26px; font-weight:800; color:var(--text-dark);
      letter-spacing:-.5px; margin-bottom:6px;
    }
    .form-subtitle { font-size:13.5px; color:var(--text-mid); }

    /* Alert error */
    .alert-error {
      background:#FEF2F2; border:1px solid #FECACA; color:var(--error);
      padding:11px 15px; border-radius:10px; font-size:13px;
      margin-bottom:22px; display:flex; align-items:center; gap:8px;
    }

    /* Form fields */
    .field-group { margin-bottom:18px; }
    .field-label {
      display:block; font-size:12.5px; font-weight:700;
      color:var(--text-dark); margin-bottom:7px; letter-spacing:.1px;
    }
    .field-wrapper { position:relative; }
    .field-icon {
      position:absolute; left:15px; top:50%; transform:translateY(-50%);
      color:var(--text-light); font-size:13px; transition:color .2s; z-index:1;
    }
    .field-input {
      width:100%; padding:12px 15px 12px 42px;
      border:1.5px solid var(--border); border-radius:10px;
      font-family:'Mulish',sans-serif; font-size:14px;
      color:var(--text-dark); background:#F8FAFC;
      transition:all .2s ease; outline:none;
    }
    .field-input::placeholder { color:var(--text-light); }
    .field-input:focus {
      border-color:var(--primary); background:var(--white);
      box-shadow:0 0 0 3px rgba(23,162,184,.12);
    }
    .field-wrapper:focus-within .field-icon { color:var(--primary); }

    /* Submit button */
    .btn-submit {
      width:100%; padding:13px;
      background:linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color:white; border:none; border-radius:10px;
      font-family:'Plus Jakarta Sans',sans-serif;
      font-size:14.5px; font-weight:700;
      cursor:pointer; transition:all .25s ease; margin-top:6px;
      display:flex; align-items:center; justify-content:center; gap:8px;
      letter-spacing:.1px;
      box-shadow:0 4px 16px rgba(23,162,184,.4);
    }
    .btn-submit:hover {
      transform:translateY(-2px);
      box-shadow:0 8px 24px rgba(23,162,184,.45);
    }
    .btn-submit:active  { transform:translateY(0); }
    .btn-submit:disabled { opacity:.75; cursor:not-allowed; transform:none; }

    .form-footer { text-align:center; margin-top:18px; }
    .form-footer a {
      font-size:13px; color:var(--primary);
      text-decoration:none; font-weight:600; transition:opacity .2s;
    }
    .form-footer a:hover { opacity:.75; }

    /* Spinner */
    .spinner {
      width:15px; height:15px;
      border:2px solid rgba(255,255,255,.3); border-top-color:white;
      border-radius:50%; animation:spin .65s linear infinite; display:none;
    }
    @keyframes spin { to { transform:rotate(360deg); } }

    /* Responsive */
    @media (max-width:720px) {
      .panel-left  { display:none; }
      .panel-right { width:100%; padding:40px 28px; }
    }
  </style>
</head>

<body>
  <div class="bg-blob bg-blob-1"></div>
  <div class="bg-blob bg-blob-2"></div>
  <div class="bg-blob bg-blob-3"></div>

  <div class="login-wrapper">

    <!-- LEFT PANEL -->
    <div class="panel-left">
      <div class="panel-left-content">
        <div class="brand">
          <img src="{{ asset('img/logo.png') }}" alt="EduSys Logo" class="brand-logo"
               onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
          <div class="brand-logo-placeholder" style="display:none;">E</div>
          <div class="brand-name">Edu<span>Sys</span></div>
        </div>

        <div class="panel-headline">
          Platform Manajemen<br>Sekolah Modern
        </div>
        <p class="panel-sub">
          Kelola data siswa, jadwal, nilai, dan laporan sekolah dalam satu platform yang terintegrasi.
        </p>
      </div>

      {{-- Stats — real data dari controller --}}
      <div class="stats-row">
        <div class="stat-item">
          <div class="stat-num">{{ $totalSiswa }}</div>
          <div class="stat-label">Siswa Aktif</div>
        </div>
        <div class="stat-item">
          <div class="stat-num">{{ $totalGuru }}</div>
          <div class="stat-label">Guru</div>
        </div>
        <div class="stat-item">
          <div class="stat-num">{{ $totalKelas }}</div>
          <div class="stat-label">Kelas</div>
        </div>
      </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="panel-right">
      <div class="form-header">
        <div class="form-tag">Secure Login</div>
        <div class="form-title">Selamat Datang</div>
        <p class="form-subtitle">Masuk ke akun EduSys Anda</p>
      </div>

      @if (Session::has('status'))
      <div class="alert-error">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('status') }}
      </div>
      @endif

      <form action="/login" method="post" id="loginForm">
        @csrf

        <div class="field-group">
          <label class="field-label" for="username">Username</label>
          <div class="field-wrapper">
            <input type="text" name="username" id="username"
              class="field-input" placeholder="Masukkan username"
              required autocomplete="username">
            <i class="fas fa-user field-icon"></i>
          </div>
        </div>

        <div class="field-group">
          <label class="field-label" for="password">Password</label>
          <div class="field-wrapper">
            <input type="password" name="password" id="password"
              class="field-input" placeholder="Masukkan password"
              required autocomplete="current-password">
            <i class="fas fa-lock field-icon"></i>
          </div>
        </div>

        <button type="submit" class="btn-submit" id="submitBtn">
          <div class="spinner" id="spinner"></div>
          <span id="btnText">Masuk Sekarang</span>
          <i class="fas fa-arrow-right" id="btnIcon"></i>
        </button>
      </form>

      <div class="form-footer">
        <a href="forgot-password.html">
          <i class="fas fa-key" style="font-size:10px;margin-right:4px;"></i>
          Lupa password?
        </a>
      </div>
    </div>

  </div>

  <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

  <script>
    $(document).ready(function () {
      $('#loginForm').on('submit', function () {
        var username = $('#username').val().trim();
        if (!username) return;
        var $btn = $('#submitBtn');
        $btn.prop('disabled', true);
        $('#spinner').css('display', 'block');
        $('#btnText').text('Memproses...');
        $('#btnIcon').hide();
      });
    });
  </script>
</body>
</html>