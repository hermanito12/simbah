@extends('layouts.app')
@section('content')
<div class="text-center py-5">
    <h1 class="display-4 text-danger">403</h1>
    <p class="text-muted">Anda tidak memiliki akses ke halaman ini.</p>
    <a href="{{ url('/') }}" class="btn btn-success">Kembali ke Beranda</a>
</div>
@endsection