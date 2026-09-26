@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Data Nasabah</h4>
    <a href="{{ route('pengurus.nasabah.create') }}" class="btn btn-success btn-sm">+ Tambah Nasabah</a>
</div>

@if (session('success'))
<div class="alert alert-success py-2">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>No. Induk</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($nasabah as $n)
                <tr>
                    <td>{{ $n->nomor_induk }}</td>
                    <td>{{ $n->nama }}</td>
                    <td>{{ $n->alamat }}</td>
                    <td>
                        @if ($n->status === 'aktif')
                        <span class="badge bg-success">Aktif</span>
                        @else
                        <span class="badge bg-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm btn-action dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-display="static" data-action-menu aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('pengurus.tabungan.index', $n) }}">Tabungan</a></li>
                                <li><a class="dropdown-item" href="{{ route('pengurus.nasabah.edit', $n) }}">Edit Data</a></li>
                                <li>
                                    <form action="{{ route('pengurus.nasabah.reset-password', $n) }}" method="POST" onsubmit="return confirm('Reset password nasabah ini?')">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Reset Password</button>
                                    </form>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('pengurus.nasabah.destroy', $n) }}" method="POST" onsubmit="return confirm('Nonaktifkan nasabah ini?')">
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
                    <td colspan="5" class="text-center text-muted py-4">Belum ada nasabah.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection