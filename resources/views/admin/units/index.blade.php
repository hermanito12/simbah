@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Data Unit/Pos Bank Sampah</h4>
    <a href="{{ route('admin.units.create') }}" class="btn btn-success btn-sm">+ Tambah Unit</a>
</div>

@if (session('success'))
<div class="alert alert-success py-2">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama Unit</th>
                    <th>Tingkat</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($units as $unit)
                <tr>
                    <td>{{ $unit->nama_unit }}</td>
                    <td>
                        <span class="badge {{ $unit->tingkat === 'RT' ? 'badge-soft-blue' : 'badge-soft-yellow' }}">
                            {{ $unit->tingkat }}
                        </span>
                    </td>
                    <td>{{ $unit->alamat }}</td>
                    <td>
                        @if ($unit->status === 'aktif')
                        <span class="badge badge-soft-green">Aktif</span>
                        @else
                        <span class="badge badge-soft-red">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm btn-action dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-display="static" data-action-menu aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.units.edit', $unit) }}">Edit</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('admin.units.destroy', $unit) }}" method="POST" onsubmit="return confirm('Nonaktifkan unit ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">Nonaktifkan</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada data Unit.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection