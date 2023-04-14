@extends('base')

@section('content')
    <div class="container my-4 px-3">
        <form class="card mx-auto" style="max-width: 700px" action="/auth/edit-account" method="POST">
            @csrf
            @method('PATCH')

            <div class="card-header fw-bold text-primary">Edit Account</div>

            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" id="name" value="{{ old('name', auth()->user()->name) }}">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" disabled class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" id="email" value="{{ old('email', auth()->user()->email) }}">
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection