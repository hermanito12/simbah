@extends('layouts.app')
@section('content')
<h4 class="mb-3">Tambah Akun Baru</h4>
<div class="alert alert-info py-2 small">Password awal dibuat otomatis dan hanya ditampilkan sekali setelah disimpan. Catat baik-baik.</div>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            @include('admin.users._form')
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection