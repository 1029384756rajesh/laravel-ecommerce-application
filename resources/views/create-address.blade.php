@extends('base')

@section('content')
    <div class="container my-4 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('addresses.index') }}">Addresses</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>

        <form class="card mx-auto" style="max-width: 700px" action="{{ route('addresses.store') }}" method="POST">
            @csrf

            <div class="card-header fw-bold text-primary">Create New Address</div>

            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name')}}" name="name" id="name">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="number" class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" value="{{ old('mobile')}}" name="mobile" id="mobile">
                    @error('mobile')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address_line_1" class="form-label">Address Line 1</label>
                    <input type="text" class="form-control {{ $errors->has('address_line_1') ? 'is-invalid' : '' }}" value="{{ old('address_line_1')}}" class="form-control" name="address_line_1" id="address_line_1">
                    @error('address_line_1')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address_line_2" class="form-label">Address Line 2</label>
                    <input type="text" class="form-control {{ $errors->has('address_line_2') ? 'is-invalid' : '' }}" value="{{ old('address_line_2')}}" name="address_line_2" id="address_line_2">
                    @error('address_line_2')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" value="{{ old('city')}}" name="city" id="city">
                    @error('city')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pincode" class="form-label">Pincode</label>
                    <input type="text" class="form-control {{ $errors->has('pincode') ? 'is-invalid' : '' }}" value="{{ old('pincode')}}" name="pincode" id="pincode">
                    @error('pincode')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection