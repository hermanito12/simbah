@extends('layouts.app')
@section('content')
<h4 class="mb-3">Edit Jenis Sampah</h4>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.jenis-sampah.update', $jenisSampah) }}">
            @csrf
            @method('PUT')
            @include('admin.jenis-sampah._form')
            <button class="btn btn-success">Update</button>
            <a href="{{ route('admin.jenis-sampah.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection