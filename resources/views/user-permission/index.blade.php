@extends('layouts/master')
@section('title', 'User - Permission')
@section('header', 'User - Permission')
@section('content')
<div class="row">
    <div class="col-lg-10">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card">
            <div class="card-header">
                <div class="card-title">Kelola Permission per User</div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Permission Langsung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @forelse($user->permissions as $permission)
                                    <span class="badge badge-success">{{ $permission->name }}</span>
                                @empty
                                    <span class="text-muted">Belum ada permission</span>
                                @endforelse
                            </td>
                            <td>
                                <a href="{{ route('user-permission.edit', $user->id) }}"
                                    class="btn btn-warning btn-sm">Kelola</a>
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
    });
</script>
@endsection