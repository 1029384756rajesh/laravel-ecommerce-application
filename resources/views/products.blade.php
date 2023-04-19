@extends('base')

@section('content')
<div class="container-fluid my-4 px-2">
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
        <form action="" class="col-12 col-md-2 col-xl-3" method="GET">
            <div class="card">
                <div class="card-header fw-bold text-primary">Filter by category</div>
                <div class="card-body d-flex flex-column gap-3">
                    {{-- @foreach ($categories as $category)
                    <label class="form-check">
                        <input class="form-check-input" {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }} type="checkbox" value="{{ $category->id }}" name="category_ids[]">
                        <span class="form-check-label">{{ $category->name }}</span>
                    </label>  
                    @endforeach       --}}
                    {!! $category_list !!}
                </div>
            </div>

        </form>
        <div class="col-12 col-md-10 col-xl-9">
            <p class="fw-bold text-primary mb-3">Category - Tshirt</p>
            <div style="display:grid; grid-template-columns:repeat(4, 1fr)">
                @foreach ($products as $product)
                <a href="" class="col text-decoration-none">
                    <img class="img-fluid" src="{{ $product->image_url }}" >
                    <p class="mb-1 mt-2 text-dark">{{ $product->name }}</p>
                    <h5 class="text-primary fw-bold">Rs. {{ $product->price }}</h5>
                </a>                    
                  
                @endforeach
                <a href="" class="col text-decoration-none">
                    <img class="img-fluid" src="https://res.cloudinary.com/dhyc0vsbz/image/upload/w_480,h_392,c_fit/v1681746725/img4_kdjt4z.webp">
                    <p class="mb-1 mt-2 text-dark">dfd</p>
                    <h5 class="text-primary fw-bold">Rs. 45</h5>
                </a>  
              
            </div>
        </div>
    </div>
</div>
@endsection