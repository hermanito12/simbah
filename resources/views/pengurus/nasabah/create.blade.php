@extends('layouts.app')
@section('content')
<h4 class="mb-3">Tambah Nasabah Baru</h4>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('pengurus.nasabah.store') }}">
            @csrf
            @include('pengurus.nasabah._form')
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('pengurus.nasabah.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection