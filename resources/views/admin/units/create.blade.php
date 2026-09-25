@extends('layouts.app')
@section('content')
<h4 class="mb-3">Tambah Unit Baru</h4>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.units.store') }}">
            @csrf
            @include('admin.units._form')
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.units.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection