@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 no-print">
    <h4 class="mb-0">Detail Transaksi #{{ $transaksi->id }}</h4>
    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">🖨️ Cetak Bukti</button>
</div>

<div class="text-center mb-3 d-none d-print-block">
    <h5 class="mb-0">SIMBAH</h5>
    <div class="small">Bukti Transaksi Setoran Sampah</div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <p class="mb-1"><strong>No. Transaksi:</strong> #{{ $transaksi->id }}</p>
        <p class="mb-1"><strong>Nasabah:</strong> {{ $transaksi->nasabah->nama }} ({{ $transaksi->nasabah->nomor_anggota }})</p>
        <p class="mb-1"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</p>
        <p class="mb-0"><strong>Metode:</strong> {{ ucfirst($transaksi->metode) }}</p>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Jenis Sampah</th>
                    <th>Berat (kg)</th>
                    <th>Harga/kg</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->detail as $d)
                <tr>
                    <td>{{ $d->jenisSampah->nama }}</td>
                    <td>{{ $d->berat }}</td>
                    <td>Rp{{ number_format($d->harga_saat_transaksi, 0, ',', '.') }}</td>
                    <td class="text-end">Rp{{ number_format($d->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <th colspan="3" class="text-end">Total</th>
                    <th class="text-end">Rp{{ number_format($transaksi->total, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<p class="small text-muted mt-3 d-none d-print-block">Dicetak dari SIMBAH pada {{ now()->format('d M Y H:i') }}</p>

<a href="{{ route('pengurus.transaksi.index') }}" class="btn btn-outline-secondary mt-3 no-print">Kembali</a>
@endsection

@push('styles')
<style>
    @media print {

        .no-print,
        nav {
            display: none !important;
        }

        body {
            background: white !important;
        }
    }
</style>
@endpush