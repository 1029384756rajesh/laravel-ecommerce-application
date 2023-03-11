@extends('admin.base')

@section('content')
<div class="container my-4 px-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header fw-bold text-primary">Create New Category</div>

        <form enctype="multipart/form-data" action="{{ route('admin.categories.store') }}" class="card-body" method="POST" novalidate>
            @csrf

            <div class="mb-3 has-validation">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" id="name" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" name="image" id="image">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection