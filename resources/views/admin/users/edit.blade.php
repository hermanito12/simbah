@extends('layouts.app')
@section('content')
<h4 class="mb-3">Edit Akun</h4>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            @include('admin.users._form')
            <button class="btn btn-success">Update</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection