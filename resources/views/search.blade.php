@extends('base')

@section('content')
<div class="container mx-auto my-4 px-2">
{{-- 

      <div class="card mx-auto mb-5" style="max-width: 700px;">
        <div class="card-header fw-bold text-primary">Search</div>
        <div class="card-body">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search by product name..." aria-label="Search by product name..." aria-describedby="button-addon2">
                <button class="btn btn-secondary" type="button" id="button-addon2">Search</button>
              </div>
        </div>
      </div> --}}
    {{-- <div class="row gy-4 gx-2">
        <div class="">
            <img src="/uploads/images/products/Thumbnail/t-1.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h4 class="text-primary h5 fw-bold">Rs. 345</h4>
        </div>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <img src="/uploads/images/products/Thumbnail/t-2.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h4 class="text-primary h5 fw-bold">Rs. 345</h4>
        </div>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <img src="/uploads/images/products/Thumbnail/t-3.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h4 class="text-primary h5 fw-bold">Rs. 345</h4>
        </div>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <img src="/uploads/images/products/Thumbnail/t-4.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h4 class="text-primary h5 fw-bold">Rs. 345</h4>
        </div>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <img src="/uploads/images/products/Thumbnail/t-5.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h4 class="text-primary h5 fw-bold">Rs. 345</h4>
        </div>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <img src="/uploads/images/products/Thumbnail/t-6.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h4 class="text-primary h5 fw-bold">Rs. 345</h4>
        </div>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <img src="/uploads/images/products/Thumbnail/t-1.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h4 class="text-primary h5 fw-bold">Rs. 345</h4>
        </div>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <img src="/uploads/images/products/Thumbnail/t-2.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h4 class="text-primary h5 fw-bold">Rs. 345</h4>
        </div>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <img src="/uploads/images/products/Thumbnail/t-3.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h4 class="text-primary h5 fw-bold">Rs. 345</h4>
        </div>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <img src="/uploads/images/products/Thumbnail/t-4.png" class="img-fluid">
            <p class="text-center mb-1 mt-2">Men's slim fit tshirt</p>
            <h4 class="text-primary text-center h5 fw-bold">Rs. 345</h4>
        </div>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <img src="/uploads/images/products/Thumbnail/t-5.png" class="img-fluid">
            <p class="text-center mb-1 mt-2">Men's slim fit tshirt</p>
            <h4 class="text-primary text-center h5 fw-bold">Rs. 345</h4>
        </div>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <img src="/uploads/images/products/Thumbnail/t-6.png" class="img-fluid">
            <p class="text-center mb-1 mt-2">Men's slim fit tshirt</p>
            <h4 class="text-primary text-center h5 fw-bold">Rs. 345</h4>
        </div>
    </div> --}}
    <div class="row gx-3">
        <form class="card mx-auto mb-4" style="max-width:700px">
            <div class="card-header fw-bold text-primary">Search</div>
            <div class="card-body">
                <div class="input-group">
                    <input name="search" type="search" class="form-control">
                    <button type="submit" value="" class="btn btn-outline-secondary"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 gy-4 gx-2 mt-3 mt-md-0">
            @foreach ($products as $product)
            <a href="" class="col text-decoration-none">
                <img src="{{ $product->image_url }}" class="img-fluid">
                <p class="mb-1 mt-2 text-dark">{{ $product->name }}</p>
                <h5 class="text-primary fw-bold">Rs. {{ $product->price }}</h5>
            </a>                    
            @endforeach
        </div>
    </div>
</div>
@endsection