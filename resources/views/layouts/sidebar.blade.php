<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
        {{-- <img src="/img/AdminLTELogo.png"
      alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3"
      style="opacity: .8"> --}}
        <span class="brand-text font-weight-light">SEKOLAH</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="
                @if(auth()->user()->role == 'siswa')
                   {{ auth()->user()->student->getFoto() }}
                @elseif(auth()->user()->role == 'admin')
                   {{ auth()->user()->admin->getFoto() }}
                @else
                   {{ auth()->user()->teacher->getFoto() }}
                @endif
                " class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="
                   @if(auth()->user()->role == 'siswa')
                   /student/profile
                   @elseif(auth()->user()->role == 'admin')
                   /admin
                   @else
                   /teacher/profile
                   @endif" class="d-block">
                    {{-- 
                        FIX: Menggunakan kolom `nama` dari tabel relasi (students/admins/teachers)
                        agar konsisten dengan data yang ditampilkan di masing-masing dashboard,
                        bukan kolom `name` dari tabel users yang bisa berbeda.
                    --}}
                    @if(auth()->user()->role == 'siswa')
                        {{ auth()->user()->student->nama }}
                    @elseif(auth()->user()->role == 'admin')
                        {{ auth()->user()->admin->nama }}
                    @else
                        {{ auth()->user()->teacher->nama }}
                    @endif
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
          with font-awesome or any other icon font library -->

                @if(auth()->user()->role == 'admin')
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/students" class="nav-link {{ Request::is('students*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Siswa</p>
                    </a>
                </li>
                <li class="nav-item">
    <a href="/admins" class="nav-link {{ Request::is('admins*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-tie"></i>
        <p>Admin</p>
    </a>
</li>
<li class="nav-item">
    <a href="/pendaftaran" class="nav-link {{ Request::is('pendaftaran*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-plus"></i>
        <p>
            Pendaftaran
            @php $jumlahPending = \App\Pendaftaran::where('status','pending')->count(); @endphp
            @if($jumlahPending > 0)
                <span class="badge badge-warning right">{{ $jumlahPending }}</span>
            @endif
        </p>
    </a>
</li>

                <li class="nav-item">
                    <a href="/class-rooms" class="nav-link {{ Request::is('class-rooms*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-school"></i>
                        <p>Kelas</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/subjects" class="nav-link {{ Request::is('subjects*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Mata Pelajaran</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/teachers" class="nav-link {{ Request::is('teachers*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Guru</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/semesters" class="nav-link {{ Request::is('semesters*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>Semester</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/wali-kelas" class="nav-link {{ Request::is('wali-kelas*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-alt"></i>
                        <p>Wali Kelas</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/class-learns" class="nav-link {{ Request::is('class-learns*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>Kelas Ajar</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/class-students" class="nav-link {{ Request::is('class-students*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chair"></i>
                        <p>Kelas Siswa</p>
                    </a>
                </li>

                {{-- <li class="nav-item">
                <a href="/absents" class="nav-link {{ Request::is('absents*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-table"></i>
                <p>Absensi Siswa</p>
                </a>
                </li> --}}

                <li class="nav-item">
                    <a href="/schedules" class="nav-link {{ Request::is('schedules*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Jadwal</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/grades" class="nav-link {{ Request::is('grades*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Nilai</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/informations" class="nav-link {{ Request::is('informations*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-info"></i>
                        <p>Pengumuman</p>
                    </a>
                </li>

                @elseif(auth()->user()->role == 'siswa')

                <li class="nav-item">
                    <a href="/student/dashboard"
                        class="nav-link {{ Request::is('student/dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/student/grades" class="nav-link {{ Request::is('student/grades') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>Nilai</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/student/schedules"
                        class="nav-link {{ Request::is('student/schedules') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Jadwal</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/student/profile" class="nav-link {{ Request::is('student/profile') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profil</p>
                    </a>
                </li>

                @else

                <li class="nav-item">
                    <a href="/teacher/dashboard"
                        class="nav-link {{ Request::is('teacher/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/teacher/profile" class="nav-link {{ Request::is('teacher/profile') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profil</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/teacher/schedules"
                        class="nav-link {{ Request::is('teacher/schedules') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Jadwal</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/teacher/grades" class="nav-link {{ Request::is('teacher/grades*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Nilai</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/teacher/homeroom-teacher"
                        class="nav-link {{ Request::is('teacher/homeroom-teacher*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Wali Kelas</p>
                    </a>
                </li>

                @endif
@if(auth()->user()->role == 'admin')
<li class="nav-header">ROLES - PERMISSIONS</li>
<li class="nav-item">
    <a href="{{ route('roles.index') }}" class="nav-link {{ Request::is('roles*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-tie"></i>
        <p>Roles List</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('permissions.index') }}" class="nav-link {{ Request::is('permissions*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-key"></i>
        <p>Permissions List</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('role-permission.index') }}" class="nav-link {{ Request::is('role-permission*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-circle"></i>
        <p>Role - Permission</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('user-role.index') }}" class="nav-link {{ Request::is('user-role*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-circle"></i>
        <p>User - Role</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('user-permission.index') }}" class="nav-link {{ Request::is('user-permission*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-circle"></i>
        <p>User - Permission</p>
    </a>
</li>
@endif
 <li class="nav-item">
                    <a href="/logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>