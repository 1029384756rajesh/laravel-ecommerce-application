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
            <img src="{{ $slider->image_url }}" class="d-block w-100">
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
        <a href="" class="col text-decoration-none">
          <img src="{{ $product->image_url }}" class="img-fluid">
          <p class="mb-1 mt-2 text-dark fw-bold">{{ $product->name }}</p>
          <h5 class="text-primary fw-bold">{{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}</h5>
        </a>          
        @endforeach
    </div>
</div>
@endsection