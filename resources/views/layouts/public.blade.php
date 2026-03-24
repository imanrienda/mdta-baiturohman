<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') - SIAKAD Sekolah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <style>
        body { background: #f4f6f9; }
        .brand-header {
            background: #343a40;
            color: white;
            padding: 12px 20px;
            margin-bottom: 30px;
        }
        .brand-header h4 { margin: 0; font-weight: 600; }
    </style>
    @yield('style')
</head>
<body>

    {{-- Header Sederhana --}}
    <div class="brand-header">
        <h4><i class="fas fa-school mr-2"></i> SIAKAD SEKOLAH</h4>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h6><i class="icon fas fa-ban"></i> Terdapat kesalahan!</h6>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')

            </div>
        </div>
    </div>

    <footer class="text-center text-muted py-4 mt-4">
        <small>Copyright &copy; {{ date('Y') }} SIAKAD Sekolah</small>
    </footer>

    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $('.date').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: 'en',
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right'
            }
        });
    </script>
    @yield('script')
</body>
</html>