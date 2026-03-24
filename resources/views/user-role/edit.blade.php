@extends('layouts/master')
@section('title', 'Edit User - ' . $user->name)
@section('header', 'Edit User: ' . $user->name)
@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-user-edit"></i> Form Edit User
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('user-role.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- INFO AKUN --}}
                    <h6 class="text-muted font-weight-bold mb-3">
                        <i class="fas fa-id-card"></i> INFO AKUN
                    </h6>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username', $user->username) }}">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Maksimal 10 karakter</small>
                    </div>

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    {{-- GANTI PASSWORD --}}
                    <h6 class="text-muted font-weight-bold mb-3">
                        <i class="fas fa-lock"></i> GANTI PASSWORD
                        <small class="text-muted font-weight-normal">(kosongkan jika tidak ingin mengubah)</small>
                    </h6>

                    <div class="form-group">
                        <label>Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Minimal 6 karakter">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary toggle-password"
                                    data-target="#password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control"
                                placeholder="Ulangi password baru">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary toggle-password"
                                    data-target="#password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- ROLE --}}
                    <h6 class="text-muted font-weight-bold mb-3">
                        <i class="fas fa-user-tag"></i> ROLE
                    </h6>

                    <div class="form-group">
                        <div class="row">
                            @foreach($roles as $role)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="roles[]" value="{{ $role->name }}"
                                        id="role_{{ $role->id }}"
                                        {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        @if($role->name == 'admin')
                                            <span class="badge badge-danger">{{ $role->name }}</span>
                                        @elseif($role->name == 'guru')
                                            <span class="badge badge-primary">{{ $role->name }}</span>
                                        @else
                                            <span class="badge badge-success">{{ $role->name }}</span>
                                        @endif
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <hr>

                    <a href="{{ route('user-role.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    // Toggle show/hide password
    $('.toggle-password').on('click', function() {
        const target = $($(this).data('target'));
        const icon = $(this).find('i');
        if (target.attr('type') === 'password') {
            target.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            target.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
</script>
@endsection