@extends('layouts.app')
@section('content')
<h4 class="mb-1">Buku Saku Digital</h4>
<p class="text-muted">{{ $nasabah->nama }} — No. Induk: {{ $nasabah->nomor_induk }}</p>

<div class="card mb-4 bg-success text-white">
    <div class="card-body text-center">
        <div class="small opacity-75">Saldo Tabungan</div>
        <div class="display-6 fw-bold">Rp{{ number_format($saldo, 0, ',', '.') }}</div>
    </div>
</div>

<h6>Riwayat Mutasi Tabungan</h6>
<div class="card mb-4">
    <div class="table-responsive">
        <table class="table table-sm mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th class="text-end">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mutasi as $m)
                <tr>
                    <td class="small">{{ \Carbon\Carbon::parse($m->tanggal)->format('d M Y') }}</td>
                    <td class="small">{{ $m->keterangan }}</td>
                    <td class="text-end small {{ $m->jenis === 'masuk' ? 'text-success' : 'text-danger' }}">
                        {{ $m->jenis === 'masuk' ? '+' : '-' }}Rp{{ number_format($m->nominal, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-3 small">Belum ada mutasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<h6>Riwayat Setoran Sampah</h6>
<div class="card">
    <div class="table-responsive">
        <table class="table table-sm mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis Sampah</th>
                    <th>Metode</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $t)
                <tr>
                    <td class="small">{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
                    <td class="small">{{ $t->detail->pluck('jenisSampah.nama')->join(', ') }}</td>
                    <td class="small">{{ ucfirst($t->metode) }}</td>
                    <td class="text-end small">Rp{{ number_format($t->total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-3 small">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection