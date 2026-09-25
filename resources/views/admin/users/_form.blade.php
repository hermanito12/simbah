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
    <label class="form-label">Nama</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
</div>

@if (!isset($user))
<div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
    <div class="form-text">Huruf, angka, - dan _ saja. Tidak bisa diubah setelah dibuat.</div>
</div>
@else
<div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" class="form-control" value="{{ $user->username }}" disabled>
</div>
@endif

<div class="mb-3">
    <label class="form-label">Role</label>
    <select name="role" id="roleSelect" class="form-select" required>
        <option value="">-- Pilih --</option>
        @foreach (['admin' => 'Admin', 'pengurus' => 'Pengurus Unit/Pos', 'kelurahan' => 'Kelurahan'] as $value => $label)
        <option value="{{ $value }}" {{ old('role', $user->role ?? '') === $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3" id="unitField">
    <label class="form-label">Unit/Pos (wajib untuk role Pengurus)</label>
    <select name="unit_id" class="form-select">
        <option value="">-- Pilih Unit --</option>
        @foreach ($units as $unit)
        <option value="{{ $unit->id }}" {{ old('unit_id', $user->unit_id ?? '') == $unit->id ? 'selected' : '' }}>
            {{ $unit->nama_unit }} ({{ $unit->tingkat }})
        </option>
        @endforeach
    </select>
</div>

<script>
    const roleSelect = document.getElementById('roleSelect');
    const unitField = document.getElementById('unitField');

    function toggleUnitField() {
        unitField.style.display = roleSelect.value === 'pengurus' ? 'block' : 'none';
    }

    roleSelect.addEventListener('change', toggleUnitField);
    toggleUnitField();
</script>