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
    <label class="form-label">Nomor Induk</label>
    <input type="text" name="nomor_induk" class="form-control" value="{{ old('nomor_induk', $nasabah->nomor_induk ?? '') }}" placeholder="Contoh: A001" required>
</div>

<div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $nasabah->nama ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Alamat</label>
    <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $nasabah->alamat ?? '') }}" required>
</div>

@isset($nasabah)
<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
        <option value="aktif" {{ old('status', $nasabah->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ old('status', $nasabah->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select>
</div>
@endisset