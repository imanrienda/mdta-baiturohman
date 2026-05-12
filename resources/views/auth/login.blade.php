<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MDTA BAIUTURROHMAN — Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary:       #3B9EE8;
      --primary-dark:  #2B85CC;
      --primary-light: #EBF5FF;
      --bg:            #C8E8F5;
      --white:         #FFFFFF;
      --text-dark:     #1A2B4A;
      --text-mid:      #5A6A85;
      --text-light:    #A0AFBF;
      --border:        #D8E8F5;
      --error:         #EF4444;
      --card-shadow:   0 8px 40px rgba(30,100,180,0.13), 0 2px 12px rgba(0,0,0,0.07);
    }

    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--bg);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    /* Soft background circles for depth */
    body::before {
      content: '';
      position: fixed;
      width: 520px; height: 520px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255,255,255,0.45), transparent 70%);
      top: -120px; right: -120px;
      pointer-events: none;
    }
    body::after {
      content: '';
      position: fixed;
      width: 400px; height: 400px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255,255,255,0.35), transparent 70%);
      bottom: -100px; left: -80px;
      pointer-events: none;
    }

    /* Main card */
    .login-card {
      position: relative; z-index: 1;
      width: 100%; max-width: 420px;
      margin: 24px;
      background: var(--white);
      border-radius: 28px;
      overflow: hidden;
      box-shadow: var(--card-shadow);
      animation: slideUp .55s cubic-bezier(.16,1,.3,1) both;
      padding: 44px 40px 40px;
      text-align: center;
    }

    @keyframes slideUp {
      from { opacity:0; transform:translateY(28px) scale(.98); }
      to   { opacity:1; transform:translateY(0) scale(1); }
    }

    /* Logo */
    .logo-wrap {
      width: 96px; height: 96px;
      background: var(--primary-light);
      border-radius: 24px;
      margin: 0 auto 20px;
      display: flex; align-items: center; justify-content: center;
      font-size: 52px;
      line-height: 1;
      animation: popIn .6s cubic-bezier(.34,1.56,.64,1) .1s both;
    }
    @keyframes popIn {
      from { opacity:0; transform:scale(.6); }
      to   { opacity:1; transform:scale(1); }
    }

    /* Brand */
    .brand-name {
      font-family: 'Nunito', sans-serif;
      font-size: 20px; font-weight: 900;
      color: var(--primary);
      letter-spacing: .5px;
      text-transform: uppercase;
      margin-bottom: 6px;
    }
    .brand-tagline {
      font-size: 13px;
      color: var(--text-mid);
      margin-bottom: 32px;
      font-weight: 400;
    }

    /* Alert */
    .alert-error {
      background: #FEF2F2; border: 1px solid #FECACA; color: var(--error);
      padding: 10px 14px; border-radius: 10px; font-size: 13px;
      margin-bottom: 18px; display: flex; align-items: center; gap: 8px;
      text-align: left;
    }

    /* Fields */
    .field-group { margin-bottom: 14px; text-align: left; }
    .field-label {
      display: block; font-size: 13px; font-weight: 600;
      color: var(--text-dark); margin-bottom: 7px;
    }
    .field-wrapper { position: relative; }
    .field-icon {
      position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
      color: var(--text-light); font-size: 13px; transition: color .2s; z-index: 1;
    }
    .field-input {
      width: 100%; padding: 13px 15px 13px 42px;
      border: 1.5px solid var(--border); border-radius: 12px;
      font-family: 'Poppins', sans-serif; font-size: 14px;
      color: var(--text-dark); background: #F5FAFF;
      transition: all .2s ease; outline: none;
    }
    .field-input::placeholder { color: var(--text-light); font-size: 13px; }
    .field-input:focus {
      border-color: var(--primary); background: var(--white);
      box-shadow: 0 0 0 3px rgba(59,158,232,.13);
    }
    .field-wrapper:focus-within .field-icon { color: var(--primary); }

    /* Submit */
    .btn-submit {
      width: 100%; padding: 14px;
      background: var(--primary);
      color: white; border: none; border-radius: 14px;
      font-family: 'Nunito', sans-serif;
      font-size: 15px; font-weight: 800;
      cursor: pointer; transition: all .22s ease; margin-top: 8px;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      letter-spacing: .2px;
      box-shadow: 0 4px 18px rgba(59,158,232,.35);
    }
    .btn-submit:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(59,158,232,.4);
    }
    .btn-submit:active  { transform: translateY(0); }
    .btn-submit:disabled { opacity: .7; cursor: not-allowed; transform: none; }

    .form-footer { text-align: center; margin-top: 18px; }
    .form-footer a {
      font-size: 13px; color: var(--primary);
      text-decoration: none; font-weight: 600; transition: opacity .2s;
    }
    .form-footer a:hover { opacity: .75; }

    /* Spinner */
    .spinner {
      width: 15px; height: 15px;
      border: 2px solid rgba(255,255,255,.35); border-top-color: white;
      border-radius: 50%; animation: spin .65s linear infinite; display: none;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* Responsive */
    @media (max-width: 480px) {
      .login-card { padding: 36px 28px 32px; }
    }
  </style>
</head>

<body>

  <div class="login-card">

    <!-- Logo -->
    <div class="logo-wrap">
      <img src="{{ asset('img/logo.png') }}" alt="Logo"
           style="width:64px;height:64px;object-fit:contain;"
           onerror="this.style.display='none';this.nextElementSibling.style.display='block';">
      <span style="display:none;">🏫</span>
    </div>

    <!-- Brand -->
    <div class="brand-name">MDTA BAIUTURROHMAN</div>
    <p class="brand-tagline">Sistem Administrasi Sekolah</p>

    <!-- Alert -->
    @if (Session::has('status'))
    <div class="alert-error">
      <i class="fas fa-exclamation-circle"></i>
      {{ session('status') }}
    </div>
    @endif

    <!-- Form -->
    <form action="/login" method="post" id="loginForm">
      @csrf

      <div class="field-group">
        <label class="field-label" for="username">Username</label>
        <div class="field-wrapper">
          <i class="fas fa-user field-icon"></i>
          <input type="text" name="username" id="username"
            class="field-input" placeholder="Masukkan username"
            required autocomplete="username">
        </div>
      </div>

      <div class="field-group">
        <label class="field-label" for="password">Password</label>
        <div class="field-wrapper">
          <i class="fas fa-lock field-icon"></i>
          <input type="password" name="password" id="password"
            class="field-input" placeholder="Masukkan password"
            required autocomplete="current-password">
        </div>
      </div>

      <button type="submit" class="btn-submit" id="submitBtn">
        <div class="spinner" id="spinner"></div>
        <i class="fas fa-rocket" id="btnIcon"></i>
        <span id="btnText">Masuk</span>
      </button>
    </form>

    <div class="form-footer">
      <a href="forgot-password.html">
        <i class="fas fa-key" style="font-size:10px;margin-right:4px;"></i>
        Lupa password?
      </a>
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