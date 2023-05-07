@extends('base')

@section('content')
    <div class="container my-4 px-3">
        <form class="card mx-auto" style="max-width: 600px" action="/account/login" method="POST">
            @csrf
@foreach ($errors as $error)
    {{$error}}
@endforeach
            <div class="card-header card-header-title">Login</div>

            <div class="card-body">
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
                <button class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
@endsection