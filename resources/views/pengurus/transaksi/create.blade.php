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

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('pengurus.transaksi.store') }}" id="formTransaksi">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nasabah</label>
                <select name="nasabah_id" class="form-select" required>
                    <option value="">-- Pilih Nasabah --</option>
                    @foreach ($nasabahList as $n)
                    <option value="{{ $n->id }}" {{ old('nasabah_id') == $n->id ? 'selected' : '' }}>
                        {{ $n->nomor_induk }} - {{ $n->nama }}
                    </option>
                    @endforeach
                </select>
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
                                <select name="items[0][jenis_sampah_id]" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($jenisSampah as $j)
                                    <option value="{{ $j->id }}">[{{ $j->kategori }}] {{ $j->nama }}</option>
                                    @endforeach
                                </select>
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

<script>
    let rowIndex = 1;
    const tbody = document.querySelector('#tabelItems tbody');
    const templateRow = tbody.querySelector('tr').cloneNode(true);

    document.getElementById('btnTambahRow').addEventListener('click', function() {
        const newRow = templateRow.cloneNode(true);
        newRow.querySelectorAll('select, input').forEach(function(el) {
            el.name = el.name.replace('[0]', '[' + rowIndex + ']');
            el.value = '';
        });
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