@extends('layouts.app')
@section('content')
<h4 class="mb-3">Edit Unit</h4>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.units.update', $unit) }}">
            @csrf
            @method('PUT')
            @include('admin.units._form')
            <button class="btn btn-success">Update</button>
            <a href="{{ route('admin.units.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection