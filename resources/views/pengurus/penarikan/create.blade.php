@extends('layouts.app')
@section('content')
<h4 class="mb-1">Catat Penarikan</h4>
<p class="text-muted">{{ $nasabah->nama }} ({{ $nasabah->nomor_induk }})</p>

<div class="alert alert-info py-2">
    Saldo saat ini: <strong>Rp{{ number_format($saldo, 0, ',', '.') }}</strong>
</div>

@if ($errors->any())
<div class="alert alert-danger py-2">
    <ul class="mb-0 small">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('pengurus.penarikan.store', $nasabah) }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nominal Penarikan (Rp)</label>
                <input type="number" step="0.01" min="0.01" max="{{ $saldo }}" name="nominal" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan <span class="text-muted">(opsional)</span></label>
                <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Diambil tunai oleh nasabah">
            </div>
            <button class="btn btn-warning">Simpan Penarikan</button>
            <a href="{{ route('pengurus.tabungan.index', $nasabah) }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection