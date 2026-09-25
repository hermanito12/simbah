@extends('layouts.app')
@section('content')
<h4 class="mb-1">Tabungan: {{ $nasabah->nama }}</h4>
<p class="text-muted small">No. Induk: {{ $nasabah->nomor_induk }}</p>

@if (session('success'))
<div class="alert alert-success py-2">{{ session('success') }}</div>
@endif

<div class="card mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <div class="text-muted small">Saldo Saat Ini</div>
            <div class="h3 mb-0">Rp{{ number_format($saldo, 0, ',', '.') }}</div>
        </div>
        <a href="{{ route('pengurus.penarikan.create', $nasabah) }}" class="btn btn-warning">Catat Penarikan</a>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Keterangan</th>
                    <th class="text-end">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mutasi as $m)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($m->tanggal)->format('d M Y') }}</td>
                    <td>
                        @if ($m->jenis === 'masuk')
                        <span class="badge bg-success">Masuk</span>
                        @else
                        <span class="badge bg-danger">Keluar</span>
                        @endif
                    </td>
                    <td>{{ $m->keterangan }}</td>
                    <td class="text-end {{ $m->jenis === 'masuk' ? 'text-success' : 'text-danger' }}">
                        {{ $m->jenis === 'masuk' ? '+' : '-' }}Rp{{ number_format($m->nominal, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">Belum ada mutasi tabungan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<a href="{{ route('pengurus.nasabah.index') }}" class="btn btn-outline-secondary mt-3">Kembali</a>
@endsection