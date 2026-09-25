@extends('layouts.app')
@section('content')
<div class="text-center py-5">
    <h1 class="display-4 text-secondary">404</h1>
    <p class="text-muted">Halaman yang Anda cari tidak ditemukan.</p>
    <a href="{{ url('/') }}" class="btn btn-success">Kembali ke Beranda</a>
</div>
@endsection