@extends('layouts.app')
@section('content')
<h4 class="mb-3">Profil Saya</h4>

@if (session('success'))
<div class="alert alert-success py-2">{{ session('success') }}</div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <h6 class="mb-3">Data Diri</h6>
        @if ($errors->hasAny(['name', 'alamat']))
        <div class="alert alert-danger py-2 small">
            @if ($errors->has('name')) <div>{{ $errors->first('name') }}</div> @endif
            @if ($errors->has('alamat')) <div>{{ $errors->first('alamat') }}</div> @endif
        </div>
        @endif
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" value="{{ $user->username }}" disabled>
            </div>
            @if ($nasabah)
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $nasabah->alamat) }}" required>
            </div>
            @endif
            <button class="btn btn-success">Simpan Perubahan</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h6 class="mb-3">Ganti Password</h6>
        @if ($errors->hasAny(['password_lama', 'password_baru']))
        <div class="alert alert-danger py-2 small">
            @if ($errors->has('password_lama')) <div>{{ $errors->first('password_lama') }}</div> @endif
            @if ($errors->has('password_baru')) <div>{{ $errors->first('password_baru') }}</div> @endif
        </div>
        @endif
        <form method="POST" action="{{ route('profile.password') }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Password Lama</label>
                <input type="password" name="password_lama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password_baru" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ulangi Password Baru</label>
                <input type="password" name="password_baru_confirmation" class="form-control" required>
            </div>
            <button class="btn btn-warning">Ubah Password</button>
        </form>
    </div>
</div>
@endsection