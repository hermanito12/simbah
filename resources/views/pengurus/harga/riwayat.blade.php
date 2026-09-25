@extends('layouts.app')
@section('content')
<h4 class="mb-3">Riwayat Harga: {{ $jenisSampah->nama }}</h4>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Harga Pengepul</th>
                    <th>Harga Nasabah</th>
                    <th>Mulai</th>
                    <th>Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayat as $h)
                <tr>
                    <td>{{ $h->harga_pengepul ? 'Rp' . number_format($h->harga_pengepul, 0, ',', '.') : '-' }}</td>
                    <td>Rp{{ number_format($h->harga_nasabah, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($h->tanggal_mulai)->format('d M Y') }}</td>
                    <td>{{ $h->tanggal_akhir ? \Carbon\Carbon::parse($h->tanggal_akhir)->format('d M Y') : 'Masih berlaku' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<a href="{{ route('pengurus.harga.index') }}" class="btn btn-outline-secondary mt-3">Kembali</a>
@endsection