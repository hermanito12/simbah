@if ($errors->any())
<div class="alert alert-danger py-2">
    <ul class="mb-0 small">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="mb-3">
    <label class="form-label">Nama Jenis Sampah</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $jenisSampah->nama ?? '') }}" placeholder="Contoh: Kardus" required>
</div>

<div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="kategori" class="form-select" required>
        <option value="">-- Pilih --</option>
        @foreach (['Kertas', 'Plastik', 'Logam', 'Lain-lain'] as $kat)
        <option value="{{ $kat }}" {{ old('kategori', $jenisSampah->kategori ?? '') === $kat ? 'selected' : '' }}>{{ $kat }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Satuan</label>
    <input type="text" name="satuan" class="form-control" value="{{ old('satuan', $jenisSampah->satuan ?? 'kg') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
        <option value="aktif" {{ old('status', $jenisSampah->status ?? 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ old('status', $jenisSampah->status ?? '') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select>
</div>