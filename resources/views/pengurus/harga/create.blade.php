@extends('layouts.app')
@section('content')
<h4 class="mb-3">Set Harga Baru</h4>
<p class="text-muted small">Kalau jenis sampah yang dipilih sudah punya harga aktif, harga lama otomatis ditutup dan tersimpan sebagai riwayat.</p>
<div class="card">
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('pengurus.harga.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Jenis Sampah</label>
                <select name="jenis_sampah_id" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    @foreach ($jenisSampah as $j)
                    <option value="{{ $j->id }}" {{ old('jenis_sampah_id') == $j->id ? 'selected' : '' }}>
                        [{{ $j->kategori }}] {{ $j->nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga Pengepul (Rp/kg) <span class="text-muted">- opsional, sekadar referensi</span></label>
                <input type="number" step="0.01" name="harga_pengepul" class="form-control" value="{{ old('harga_pengepul') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Harga untuk Nasabah (Rp/kg)</label>
                <input type="number" step="0.01" name="harga_nasabah" class="form-control" value="{{ old('harga_nasabah') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Berlaku Mulai Tanggal</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', now()->format('Y-m-d')) }}" required>
            </div>
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('pengurus.harga.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection