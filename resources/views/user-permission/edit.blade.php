@extends('layouts/master')
@section('title', 'Kelola Permission - ' . $user->name)
@section('header', 'Kelola Permission untuk User: ' . $user->name)
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Assign Permission ke User <strong>{{ $user->name }}</strong></div>
            </div>
            <div class="card-body">
                <form action="{{ route('user-permission.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Pilih Permissions</label>
                        <div class="row">
                            @foreach($permissions as $permission)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="permissions[]" value="{{ $permission->name }}"
                                        id="perm_{{ $permission->id }}"
                                        {{ $user->hasDirectPermission($permission->name) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($permissions->isEmpty())
                            <p class="text-muted">Belum ada permission. <a href="{{ route('permissions.create') }}">Tambah dulu</a></p>
                        @endif
                    </div>
                    <a href="{{ route('user-permission.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection