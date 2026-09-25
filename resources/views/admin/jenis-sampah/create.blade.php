@extends('layouts.app')
@section('content')
<h4 class="mb-3">Tambah Jenis Sampah</h4>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.jenis-sampah.store') }}">
            @csrf
            @include('admin.jenis-sampah._form')
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.jenis-sampah.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection