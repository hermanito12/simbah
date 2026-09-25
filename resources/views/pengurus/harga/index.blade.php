@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Harga Sampah Berlaku</h4>
    <a href="{{ route('pengurus.harga.create') }}" class="btn btn-success btn-sm">+ Set Harga Baru</a>
</div>

@if (session('success'))
<div class="alert alert-success py-2">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Jenis Sampah</th>
                    <th>Harga Pengepul</th>
                    <th>Harga Nasabah</th>
                    <th>Berlaku Sejak</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($hargaAktif as $h)
                <tr>
                    <td>{{ $h->jenisSampah->nama }}</td>
                    <td>{{ $h->harga_pengepul ? 'Rp' . number_format($h->harga_pengepul, 0, ',', '.') : '-' }}</td>
                    <td><strong>Rp{{ number_format($h->harga_nasabah, 0, ',', '.') }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($h->tanggal_mulai)->format('d M Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('pengurus.harga.riwayat', $h->jenis_sampah_id) }}" class="btn btn-outline-secondary btn-sm">Riwayat</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada harga diset. Set harga dulu sebelum bisa transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection