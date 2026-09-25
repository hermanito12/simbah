@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Master Jenis Sampah</h4>
    <a href="{{ route('admin.jenis-sampah.create') }}" class="btn btn-success btn-sm">+ Tambah Jenis</a>
</div>

@if (session('success'))
<div class="alert alert-success py-2">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kategori</th>
                    <th>Nama</th>
                    <th>Satuan</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jenisSampah as $j)
                <tr>
                    <td>
                        <span class="badge {{ match (strtolower((string) $j->kategori)) {
                            'kertas' => 'badge-soft-blue',
                            'plastik' => 'badge-soft-yellow',
                            'logam' => 'badge-soft-gray',
                            default => 'badge-soft-green',
                        } }}">
                            {{ $j->kategori }}
                        </span>
                    </td>
                    <td>{{ $j->nama }}</td>
                    <td>{{ $j->satuan }}</td>
                    <td>
                        <span class="badge {{ $j->status === 'aktif' ? 'badge-soft-green' : 'badge-soft-red' }}">
                            {{ ucfirst($j->status) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.jenis-sampah.edit', $j) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                        <form action="{{ route('admin.jenis-sampah.destroy', $j) }}" method="POST" class="d-inline" onsubmit="return confirm('Nonaktifkan jenis sampah ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Nonaktifkan</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection