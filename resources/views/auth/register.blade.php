@extends('base')

@section('content')
    <div class="container my-4 px-3">
        <form class="card mx-auto max-w-xl" action="/account" method="POST">
            @csrf

            <div class="card-header card-header-title">Register</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'form-control-error' : '' }}" name="name" id="name" value="{{ old('name') }}">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control {{ $errors->has('email') ? 'form-control-error' : '' }}" name="email" id="email" value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control {{ $errors->has('password') ? 'form-control-error' : '' }}" name="password" id="password">
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                </div>
                <button class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>
@endsection