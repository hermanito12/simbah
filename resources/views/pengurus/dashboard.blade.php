@extends('layouts.app')
@section('content')
<h3 class="page-heading">Dashboard Pengurus</h3>
<p class="page-intro">Unit: {{ auth()->user()->unit->nama_unit ?? '- (belum diatur, hubungi Admin) -' }}</p>
<a href="{{ route('pengurus.transaksi.create') }}" class="btn btn-success me-2 mb-2">Catat Setoran</a>
<a href="{{ route('pengurus.transaksi.index') }}" class="btn btn-outline-success me-2 mb-2">Riwayat Transaksi</a>
<a href="{{ route('pengurus.rekap.index') }}" class="btn btn-outline-success me-2 mb-2">Rekap Transaksi</a>
<a href="{{ route('pengurus.nasabah.index') }}" class="btn btn-outline-success me-2 mb-2">Kelola Nasabah</a>
<a href="{{ route('pengurus.harga.index') }}" class="btn btn-outline-success mb-2">Kelola Harga Sampah</a>
@endsection