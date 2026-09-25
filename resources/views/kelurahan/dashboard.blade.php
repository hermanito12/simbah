@extends('layouts.app')
@section('content')
<h4 class="mb-3">Dashboard Kelurahan</h4>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('kelurahan.dashboard') }}" class="row g-2 align-items-end">
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
                <div class="text-muted small">Jumlah Unit Aktif</div>
                <div class="h4 mb-0">{{ $jumlahUnit }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <div class="text-muted small">Jumlah Nasabah</div>
                <div class="h4 mb-0">{{ $jumlahNasabah }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <div class="text-muted small">Jumlah Transaksi</div>
                <div class="h4 mb-0">{{ $jumlahTransaksi }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <div class="text-muted small">Total Berat</div>
                <div class="h5 mb-0">{{ number_format($totalBerat, 2) }} kg</div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body text-center">
        <div class="text-muted small">Total Nilai Transaksi (Periode Ini)</div>
        <div class="h3 mb-0">Rp{{ number_format($totalNilai, 0, ',', '.') }}</div>
    </div>
</div>

<h6>Rekap per Unit/Pos</h6>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama Unit</th>
                    <th>Tingkat</th>
                    <th class="text-end">Nasabah Aktif</th>
                    <th class="text-end">Transaksi</th>
                    <th class="text-end">Berat (kg)</th>
                    <th class="text-end">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rekapPerUnit as $u)
                <tr>
                    <td>{{ $u->nama_unit }}</td>
                    <td><span class="badge bg-secondary">{{ $u->tingkat }}</span></td>
                    <td class="text-end">{{ $u->nasabah_count }}</td>
                    <td class="text-end">{{ $u->jumlah_transaksi }}</td>
                    <td class="text-end">{{ number_format($u->total_berat, 2) }}</td>
                    <td class="text-end">Rp{{ number_format($u->total_nilai, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada Unit terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection