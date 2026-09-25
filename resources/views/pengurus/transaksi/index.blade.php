@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Riwayat Transaksi</h4>
    <a href="{{ route('pengurus.transaksi.create') }}" class="btn btn-success btn-sm">+ Catat Setoran</a>
</div>

@if (session('success'))
<div class="alert alert-success py-2">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Nasabah</th>
                    <th>Jenis Sampah</th>
                    <th>Metode</th>
                    <th class="text-end">Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $t)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
                    <td>{{ $t->nasabah->nama }}</td>
                    <td class="small text-muted">{{ $t->detail->pluck('jenisSampah.nama')->join(', ') }}</td>
                    <td>
                        @if ($t->metode === 'tabungan')
                        <span class="badge bg-primary">Tabungan</span>
                        @else
                        <span class="badge bg-warning text-dark">Tunai</span>
                        @endif
                    </td>
                    <td class="text-end">Rp{{ number_format($t->total, 0, ',', '.') }}</td>
                    <td class="text-end">
                        <a href="{{ route('pengurus.transaksi.show', $t) }}" class="btn btn-outline-secondary btn-sm">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $transaksi->links() }}
</div>
@endsection