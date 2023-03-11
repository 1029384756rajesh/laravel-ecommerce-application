@extends('admin.base')

@section('content')
<div class="container my-4 px-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header fw-bold text-primary">Edit Setting</div>

        <form action="{{ route('admin.settings.update') }}" class="card-body" method="POST" novalidate>
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="about" class="form-label">About</label>
                <textarea class="form-control {{ $errors->has('about') ? 'is-invalid' : '' }}" name="about" id="about">{{ old('about', $setting->about) }}</textarea>
                @error('about')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div>{{$error}}</div>
            @endforeach
        @endif
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="number" class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" name="mobile" id="mobile" value="{{ old('mobile', $setting->mobile) }}">
                @error('mobile')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" id="email" value="{{ old('email', $setting->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="facebook_url" class="form-label">Facebook URL</label>
                <input type="text" class="form-control {{ $errors->has('facebook_url') ? 'is-invalid' : '' }}" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', $setting->facebook_url) }}">
                @error('facebook_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="instagram_url" class="form-label">Instagram URL</label>
                <input type="text" class="form-control {{ $errors->has('instagra_url') ? 'is-invalid' : '' }}" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $setting->instagram_url) }}">
                @error('instagram_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="twitter_url" class="form-label">Twitter URL</label>
                <input type="text" class="form-control {{ $errors->has('twitter_url') ? 'is-invalid' : '' }}" name="twitter_url" id="twitter_url" value="{{ old('twitter_url', $setting->twitter_url) }}">
                @error('twitter_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gst" class="form-label">GST</label>
                <input type="text" class="form-control {{ $errors->has('gst') ? 'is-invalid' : '' }}" name="gst" id="gst" value="{{ old('gst', $setting->gst) }}">
                @error('gst')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="delivery_fee" class="form-label">Delivery Fee</label>
                <input type="text" class="form-control {{ $errors->has('delivery_fee') ? 'is-invalid' : '' }}" name="delivery_fee" id="delivery_fee" value="{{ old('delivery_fee', $setting->delivery_fee) }}">
                @error('delivery_fee')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="return_address" class="form-label">Return Address</label>
                <input type="text" class="form-control {{ $errors->has('return_address') ? 'is-invalid' : '' }}" name="return_address" id="return_address" value="{{ old('return_address', $setting->return_address) }}">
                @error('return_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-warning">Update</button>
        </form>
    </div>
</div>
@endsection