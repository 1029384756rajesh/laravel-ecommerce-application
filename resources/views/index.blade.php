@extends('base')

@section('content')
<div class="container my-4 px-3">
    <div id="carouselCaption" class="carousel slide">
        <div class="carousel-indicators">
          @foreach ($sliders as $slider)
          <button type="button" data-bs-target="#carouselCaption" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->index == 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide 1"></button>
              
          @endforeach
         
        </div>
        <div class="carousel-inner">
          @foreach ($sliders as $slider)
          <div class="carousel-item active">
            <img src="/uploads/{{ $slider->image_url }}" class="d-block w-100">
            <div class="carousel-caption d-none d-md-block">
              <h5>{{ $slider->title }}</h5>
              <p>{{ $slider->description }}</p>
            </div>
          </div> 
          @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselCaption" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselCaption" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

      <h2 class="fw-bold text-primary h4 text-center my-5">FEATURED PRODUCTS</h2>

      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 gy-4 gx-2">
        @foreach ($products as $product)
        <div class="col">
          <img src="/uploads/{{ $product->image_url }}" class="img-fluid">
          <p class="mb-1 mt-2">{{ $product->name }}</p>
          <h5 class="text-primary fw-bold">Rs. {{ $product->price }}</h5>
        </div>          
        @endforeach

        <div class="col">
            <img src="/uploads/images/products/Thumbnail/t-2.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h5 class="text-primary fw-bold">Rs. 345</h5>
        </div>
        <div class="col">
            <img src="/uploads/images/products/Thumbnail/t-3.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h5 class="text-primary fw-bold">Rs. 345</h5>
        </div>
        <div class="col">
            <img src="/uploads/images/products/Thumbnail/t-4.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h5 class="text-primary fw-bold">Rs. 345</h5>
        </div>
        <div class="col">
            <img src="/uploads/images/products/Thumbnail/t-5.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h5 class="text-primary fw-bold">Rs. 345</h5>
        </div>
        <div class="col">
            <img src="/uploads/images/products/Thumbnail/t-6.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h5 class="text-primary fw-bold">Rs. 345</h5>
        </div>
        <div class="col">
            <img src="/uploads/images/products/Thumbnail/t-1.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h5 class="text-primary fw-bold">Rs. 345</h5>
        </div>
        <div class="col">
            <img src="/uploads/images/products/Thumbnail/t-2.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h5 class="text-primary fw-bold">Rs. 345</h5>
        </div>
        <div class="col">
            <img src="/uploads/images/products/Thumbnail/t-3.png" class="img-fluid">
            <p class="mb-1 mt-2">Men's slim fit tshirt</p>
            <h5 class="text-primary fw-bold">Rs. 345</h5>
        </div>
    </div>
</div>
@endsection