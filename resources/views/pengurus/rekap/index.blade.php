@extends('layouts.app')
@section('content')
<h4 class="mb-3">Rekap Transaksi Unit</h4>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('pengurus.rekap.index') }}" class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label small mb-1">Dari Tanggal</label>
                <input type="date" name="tanggal_mulai" class="form-control form-control-sm" value="{{ $tanggalMulai }}">
            </div>
            <div class="col-auto">
                <label class="form-label small mb-1">Sampai Tanggal</label>
                <input type="date" name="tanggal_akhir" class="form-control form-control-sm" value="{{ $tanggalAkhir }}">
            </div>
            <div class="col-auto">
                <button class="btn btn-success btn-sm">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <div class="text-muted small">Jumlah Transaksi</div>
                <div class="h4 mb-0">{{ $totalTransaksi }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <div class="text-muted small">Total Berat</div>
                <div class="h4 mb-0">{{ number_format($totalBerat, 2) }} kg</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <div class="text-muted small">Total Nilai</div>
                <div class="h5 mb-0">Rp{{ number_format($totalNilai, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <div class="text-muted small">Tabungan / Tunai</div>
                <div class="small mb-0">
                    Rp{{ number_format($totalTabungan, 0, ',', '.') }} /
                    Rp{{ number_format($totalTunai, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</div>

<h6>Rekap per Jenis Sampah</h6>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Jenis Sampah</th>
                    <th class="text-end">Total Berat (kg)</th>
                    <th class="text-end">Total Nilai</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($breakdownJenis as $b)
                <tr>
                    <td>{{ $b->nama_jenis }}</td>
                    <td class="text-end">{{ number_format($b->total_berat, 2) }}</td>
                    <td class="text-end">Rp{{ number_format($b->total_nilai, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-4">Tidak ada transaksi pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection