@extends('layouts/master')
@section('title', 'Role - Permission')
@section('header', 'Role - Permission')
@section('content')
<div class="row">
    <div class="col-lg-10">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card">
            <div class="card-header">
                <div class="card-title">Kelola Permission per Role</div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Role</th>
                            <th>Permissions</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @forelse($role->permissions as $permission)
                                    <span class="badge badge-info">{{ $permission->name }}</span>
                                @empty
                                    <span class="text-muted">Belum ada permission</span>
                                @endforelse
                            </td>
                            <td>
                                <a href="{{ route('role-permission.edit', $role->id) }}"
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