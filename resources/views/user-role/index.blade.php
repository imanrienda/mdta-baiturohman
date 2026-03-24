@extends('layouts/master')
@section('title', 'User - Role')
@section('header', 'Manajemen User & Role')
@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="card">
            <div class="card-header">
                <div class="card-title">Daftar Semua User</div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @forelse($user->roles as $role)
                                    @if($role->name == 'admin')
                                        <span class="badge badge-danger">{{ $role->name }}</span>
                                    @elseif($role->name == 'guru')
                                        <span class="badge badge-primary">{{ $role->name }}</span>
                                    @else
                                        <span class="badge badge-success">{{ $role->name }}</span>
                                    @endif
                                @empty
                                    <span class="badge badge-secondary">Belum ada role</span>
                                @endforelse
                            </td>
                            <td>
                                <a href="{{ route('user-role.edit', $user->id) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('user-role.destroy', $user->id) }}"
                                    method="POST" class="d-inline delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="fas fa-lock"></i> Akun Ini
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
        $('#datatable').on('click', '.delete', function(e) {
            e.preventDefault();
            const form = $(this);
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: "User ini akan dihapus permanen!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection