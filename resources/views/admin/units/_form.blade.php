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
    <label class="form-label">Nama Unit</label>
    <input type="text" name="nama_unit" class="form-control" value="{{ old('nama_unit', $unit->nama_unit ?? '') }}" placeholder="Contoh: Bank Sampah RW 01" required>
</div>

<div class="mb-3">
    <label class="form-label">Tingkat</label>
    <select name="tingkat" class="form-select" required>
        <option value="">-- Pilih --</option>
        <option value="RT" {{ old('tingkat', $unit->tingkat ?? '') === 'RT' ? 'selected' : '' }}>RT</option>
        <option value="RW" {{ old('tingkat', $unit->tingkat ?? '') === 'RW' ? 'selected' : '' }}>RW</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Alamat</label>
    <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $unit->alamat ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
        <option value="aktif" {{ old('status', $unit->status ?? 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ old('status', $unit->status ?? '') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select>
</div>