@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Kelola Akun (Admin, Pengurus, Kelurahan)</h4>
    <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">+ Tambah Akun</a>
</div>

@if (session('success'))
<div class="alert alert-success py-2">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger py-2">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Unit</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->username }}</td>
                    <td>
                        <span class="badge {{ match (strtolower((string) $u->role)) {
                            'admin' => 'badge-soft-red',
                            'pengurus' => 'badge-soft-blue',
                            'kelurahan' => 'badge-soft-green',
                            default => 'badge-soft-gray',
                            } }}">
                            {{ ucfirst($u->role) }}
                        </span>
                    </td>
                    <td>{{ $u->unit->nama_unit ?? '-' }}</td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm btn-action" type="button" data-bs-toggle="dropdown">
                                Aksi
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.users.edit', $u) }}">Edit</a></li>
                                <li>
                                    <form action="{{ route('admin.users.reset-password', $u) }}" method="POST" onsubmit="return confirm('Reset password akun ini?')">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Reset Password</button>
                                    </form>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Yakin hapus akun ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada akun.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection