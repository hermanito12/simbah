@extends('layouts.app')
@section('content')
<h4 class="mb-3">Catat Setoran Sampah</h4>

@if ($errors->any())
<div class="alert alert-danger py-2">
    <ul class="mb-0 small">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@php
    $selectedNasabah = $nasabahList->firstWhere('id', old('nasabah_id'));
    $selectedJenisSampah = $jenisSampah->firstWhere('id', old('items.0.jenis_sampah_id'));
@endphp

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('pengurus.transaksi.store') }}" id="formTransaksi">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nasabah</label>
                <div class="search-picker" data-search-picker>
                    <input type="search" class="form-control search-picker-input" placeholder="Cari nama atau nomor induk..." autocomplete="off" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="nasabahOptions" aria-label="Cari nasabah" value="{{ $selectedNasabah ? $selectedNasabah->nomor_induk . ' - ' . $selectedNasabah->nama : '' }}" required>
                    <input type="hidden" name="nasabah_id" class="search-picker-value" value="{{ $selectedNasabah?->id }}">
                    <div class="search-picker-menu" id="nasabahOptions" role="listbox" hidden>
                    @foreach ($nasabahList as $n)
                        <button type="button" class="search-picker-option" role="option" aria-selected="{{ $selectedNasabah && $selectedNasabah->id === $n->id ? 'true' : 'false' }}" data-value="{{ $n->id }}" data-label="{{ $n->nomor_induk }} - {{ $n->nama }}" data-search="{{ strtolower($n->nomor_induk . ' ' . $n->nama) }}">{{ $n->nomor_induk }} - {{ $n->nama }}</button>
                    @endforeach
                        <div class="search-picker-empty small text-muted px-3 py-2" role="status" hidden>Tidak ada nasabah yang cocok.</div>
                    </div>
                </div>
                @if ($nasabahList->isEmpty())
                <div class="form-text text-danger">Belum ada nasabah aktif. Tambahkan nasabah dulu.</div>
                @endif
            </div>

            <label class="form-label">Detail Sampah</label>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="tabelItems">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 55%">Jenis Sampah</th>
                            <th style="width: 30%">Berat (kg)</th>
                            <th style="width: 15%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="search-picker" data-search-picker>
                                    <input type="search" class="form-control search-picker-input" placeholder="Cari jenis atau kategori..." autocomplete="off" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="jenisOptions-0" aria-label="Cari jenis sampah" value="{{ $selectedJenisSampah ? '[' . $selectedJenisSampah->kategori . '] ' . $selectedJenisSampah->nama : '' }}" required>
                                    <input type="hidden" name="items[0][jenis_sampah_id]" class="search-picker-value" value="{{ $selectedJenisSampah?->id }}">
                                    <div class="search-picker-menu" id="jenisOptions-0" role="listbox" hidden>
                                    @foreach ($jenisSampah as $j)
                                        <button type="button" class="search-picker-option" role="option" aria-selected="{{ $selectedJenisSampah && $selectedJenisSampah->id === $j->id ? 'true' : 'false' }}" data-value="{{ $j->id }}" data-label="[{{ $j->kategori }}] {{ $j->nama }}" data-search="{{ strtolower($j->kategori . ' ' . $j->nama) }}">{{ $j->nama }} <span class="text-muted small">{{ $j->kategori }}</span></button>
                                    @endforeach
                                        <div class="search-picker-empty small text-muted px-3 py-2" role="status" hidden>Tidak ada jenis sampah yang cocok.</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="number" step="0.01" min="0.01" name="items[0][berat]" class="form-control" required>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-hapus-row" disabled>Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-outline-secondary btn-sm mb-3" id="btnTambahRow">+ Tambah Jenis Sampah</button>

            <div class="mb-3">
                <label class="form-label">Metode Penyelesaian</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="metode" value="tabungan" id="metodeTabungan" checked>
                    <label class="form-check-label" for="metodeTabungan">Tabungan (saldo nasabah bertambah)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="metode" value="tunai" id="metodeTunai">
                    <label class="form-check-label" for="metodeTunai">Tunai (dibayar langsung)</label>
                </div>
            </div>

            <div class="alert alert-info py-2 small">
                Catatan: total nilai akan dihitung otomatis oleh sistem berdasarkan harga yang sedang berlaku, bukan hasil input manual.
            </div>

            <button type="submit" class="btn btn-success">Simpan Transaksi</button>
            <a href="{{ route('pengurus.transaksi.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>

<style>
    .search-picker {
        min-width: 0;
    }

    .search-picker-menu {
        position: fixed;
        z-index: 1080;
        max-height: min(15rem, 40vh);
        overflow-y: auto;
        padding: 0.35rem;
        border: 1px solid var(--simba-border);
        border-radius: 6px;
        background: #fff;
        box-shadow: 0 8px 20px rgba(42, 75, 57, 0.16);
    }

    .search-picker-menu[hidden],
    .search-picker-option[hidden],
    .search-picker-empty[hidden] {
        display: none;
    }

    .search-picker-option {
        display: block;
        width: 100%;
        padding: 0.55rem 0.7rem;
        border: 0;
        border-radius: 4px;
        background: transparent;
        color: var(--simba-ink);
        text-align: left;
    }

    .search-picker-option:hover,
    .search-picker-option:focus,
    .search-picker-option[aria-selected="true"] {
        outline: none;
        background: #edf5ef;
    }
</style>

<script>
    let rowIndex = 1;
    const tbody = document.querySelector('#tabelItems tbody');
    const templateRow = tbody.querySelector('tr').cloneNode(true);
    const transactionForm = document.getElementById('formTransaksi');
    let openSearchPicker = null;

    function normalizeSearchText(value) {
        return value.toLocaleLowerCase('id').replace(/[\[\]]/g, '').replace(/\s+/g, ' ').trim();
    }

    function positionSearchMenu(picker) {
        const input = picker.querySelector('.search-picker-input');
        const menu = picker.querySelector('.search-picker-menu');
        const bounds = input.getBoundingClientRect();
        const margin = 8;
        const gap = 6;
        const maxHeight = Math.min(window.innerHeight * 0.4, 240);
        const naturalHeight = Math.min(menu.scrollHeight, maxHeight);
        const availableAbove = Math.max(0, bounds.top - margin - gap);
        const availableBelow = Math.max(0, window.innerHeight - bounds.bottom - margin - gap);
        const openAbove = naturalHeight > availableBelow && availableAbove > availableBelow;
        const availableHeight = openAbove ? availableAbove : availableBelow;
        const menuHeight = Math.min(naturalHeight, availableHeight);
        const menuWidth = Math.min(bounds.width, window.innerWidth - margin * 2);
        const left = Math.max(margin, Math.min(bounds.left, window.innerWidth - menuWidth - margin));
        const top = openAbove ? bounds.top - menuHeight - gap : bounds.bottom + gap;

        menu.style.maxHeight = `${menuHeight}px`;
        menu.style.left = `${left}px`;
        menu.style.top = `${top}px`;
        menu.style.width = `${menuWidth}px`;
    }

    function closeSearchPicker(picker) {
        picker.querySelector('.search-picker-menu').hidden = true;
        picker.querySelector('.search-picker-input').setAttribute('aria-expanded', 'false');
        if (openSearchPicker === picker) openSearchPicker = null;
    }

    function filterSearchPicker(picker) {
        const input = picker.querySelector('.search-picker-input');
        const query = normalizeSearchText(input.value);
        const options = [...picker.querySelectorAll('.search-picker-option')];
        let visibleCount = 0;

        options.forEach(function(option) {
            const matches = normalizeSearchText(option.dataset.search).includes(query);
            option.hidden = !matches;
            option.setAttribute('aria-selected', 'false');
            if (matches) visibleCount++;
        });

        picker.querySelector('.search-picker-empty').hidden = visibleCount > 0;
        const menu = picker.querySelector('.search-picker-menu');
        menu.hidden = false;
        input.setAttribute('aria-expanded', 'true');
        openSearchPicker = picker;
        positionSearchMenu(picker);
    }

    function selectSearchOption(option) {
        const picker = option.closest('[data-search-picker]');
        const input = picker.querySelector('.search-picker-input');
        const value = picker.querySelector('.search-picker-value');

        input.value = option.dataset.label;
        input.setCustomValidity('');
        value.value = option.dataset.value;
        picker.querySelectorAll('.search-picker-option').forEach(function(item) {
            item.setAttribute('aria-selected', item === option ? 'true' : 'false');
        });
        input.focus();
        closeSearchPicker(picker);
    }

    transactionForm.addEventListener('focusin', function(e) {
        if (e.target.classList.contains('search-picker-input')) {
            filterSearchPicker(e.target.closest('[data-search-picker]'));
        }
    });

    transactionForm.addEventListener('input', function(e) {
        if (!e.target.classList.contains('search-picker-input')) return;

        const picker = e.target.closest('[data-search-picker]');
        picker.querySelector('.search-picker-value').value = '';
        e.target.setCustomValidity('');
        filterSearchPicker(picker);
    });

    transactionForm.addEventListener('click', function(e) {
        const option = e.target.closest('.search-picker-option');
        if (option) selectSearchOption(option);
    });

    transactionForm.addEventListener('keydown', function(e) {
        const picker = e.target.closest('[data-search-picker]');
        if (!picker) return;

        const options = [...picker.querySelectorAll('.search-picker-option:not([hidden])')];
        if (e.target.classList.contains('search-picker-input') && e.key === 'ArrowDown' && options.length) {
            e.preventDefault();
            options[0].focus();
        } else if (e.target.classList.contains('search-picker-option') && e.key === 'ArrowDown') {
            e.preventDefault();
            options[Math.min(options.indexOf(e.target) + 1, options.length - 1)].focus();
        } else if (e.target.classList.contains('search-picker-option') && e.key === 'ArrowUp') {
            e.preventDefault();
            const previousIndex = options.indexOf(e.target) - 1;
            if (previousIndex < 0) picker.querySelector('.search-picker-input').focus();
            else options[previousIndex].focus();
        } else if (e.key === 'Escape') {
            picker.querySelector('.search-picker-input').focus();
            closeSearchPicker(picker);
        }
    });

    document.addEventListener('click', function(e) {
        if (openSearchPicker && !openSearchPicker.contains(e.target)) {
            closeSearchPicker(openSearchPicker);
        }
    });

    window.addEventListener('scroll', function() {
        if (openSearchPicker) positionSearchMenu(openSearchPicker);
    }, true);
    window.addEventListener('resize', function() {
        if (openSearchPicker) positionSearchMenu(openSearchPicker);
    });

    transactionForm.addEventListener('submit', function(e) {
        const pickers = [...transactionForm.querySelectorAll('[data-search-picker]')];
        const invalidPicker = pickers.find(function(picker) {
            const input = picker.querySelector('.search-picker-input');
            const hasSelection = picker.querySelector('.search-picker-value').value !== '';
            input.setCustomValidity(hasSelection ? '' : 'Pilih salah satu opsi dari daftar.');
            return !hasSelection;
        });

        if (invalidPicker) {
            e.preventDefault();
            invalidPicker.querySelector('.search-picker-input').reportValidity();
        }
    });

    document.getElementById('btnTambahRow').addEventListener('click', function() {
        const newRow = templateRow.cloneNode(true);
        newRow.querySelectorAll('select, input').forEach(function(el) {
            el.name = el.name.replace('[0]', '[' + rowIndex + ']');
            el.value = '';
        });
        const input = newRow.querySelector('.search-picker-input');
        const options = newRow.querySelector('.search-picker-menu');
        options.id = `jenisOptions-${rowIndex}`;
        input.setAttribute('aria-controls', options.id);
        input.setAttribute('aria-expanded', 'false');
        newRow.querySelector('.btn-hapus-row').disabled = false;
        tbody.appendChild(newRow);
        rowIndex++;
    });

    tbody.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-hapus-row') && tbody.rows.length > 1) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endsection