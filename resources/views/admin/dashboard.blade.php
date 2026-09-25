@extends('layouts.app')
@section('content')
<h3 class="page-heading">Dashboard Admin</h3>
<p class="page-intro">Selamat datang, {{ auth()->user()->name }}.</p>
<a href="{{ route('admin.units.index') }}" class="btn btn-success me-2 mb-2">Kelola Unit/Pos</a>
<a href="{{ route('admin.users.index') }}" class="btn btn-outline-success me-2 mb-2">Kelola Akun</a>
<a href="{{ route('admin.jenis-sampah.index') }}" class="btn btn-outline-success mb-2">Kelola Jenis Sampah</a>
@endsection