@extends('base')

@section('content')
<div class="container my-4 px-3">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js" integrity="sha512-Gfrxsz93rxFuB7KSYlln3wFqBaXUc1jtt3dGCp+2jTb563qYvnUBM/GP2ZUtRC27STN/zUamFtVFAIsRFoT6/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<link rel="stylesheet" href="/assets/lightslider.css">



  <div>
    <p class="fw-bold h5 text-primary">Women</p>
    <div style="position: relative">
      <div class="d-flex align-items-center justify-content-center" style="top:50%; position: absolute; left:0; height:40px;width:40px;border-radius:50%;background-color:gray;z-index:999;">
        <span class="material-icons">arrow_back</span>
      </div>
      <div class="responsive" >
        @foreach ($products as $product)
        <a href="/products/{{ $product->id }}" class="col text-decoration-none">
          <img src="{{ $product->image_url }}" class="img-fluid">
          <p class="mb-1 mt-2 text-dark fw-bold">{{ $product->name }}</p>
          <h5 class="text-primary fw-bold">{{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}</h5>
        </a>          
    @endforeach
      </div>
    </div>
  </div>
  <div>
    <p class="fw-bold h5 text-primary">Men</p>
    <div class="responsive" >
      @foreach ($products as $product)
      <a href="/products/{{ $product->id }}" class="col text-decoration-none">
        <img src="{{ $product->image_url }}" class="img-fluid">
        <p class="mb-1 mt-2 text-dark fw-bold">{{ $product->name }}</p>
        <h5 class="text-primary fw-bold">{{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}</h5>
      </a>          
  @endforeach
    </div>
  </div>
  <div>
    <p class="fw-bold h5 text-primary">Kids</p>
    <div class="responsive" >
      @foreach ($products as $product)
      <a href="/products/{{ $product->id }}" class="col text-decoration-none">
        <img src="{{ $product->image_url }}" class="img-fluid">
        <p class="mb-1 mt-2 text-dark fw-bold">{{ $product->name }}</p>
        <h5 class="text-primary fw-bold">{{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}</h5>
      </a>          
  @endforeach
    </div>
  </div>



<script>
    $(document).ready(function() {
    $('.responsive').lightSlider({
        item:4,
        loop:true,
        pauseOnHover:true,
        pager:true,
        prevHtml: '',
            nextHtml: '',
        auto: true,
        slideMove:2,
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        speed:600,
        responsive : [
            {
                breakpoint:800,
                settings: {
                    item:2,
                    slideMove:1,
                    slideMargin:6,
                  }
            },
            {
                breakpoint:480,
                settings: {
                    item:2,
                    slideMove:1
                  }
            }
        ]
    });  
  });
</script>











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
        <a href="/products/{{ $product->id }}" class="col text-decoration-none" style="text-align:center">
          <img src="{{ $product->image_url }}" class="img-fluid">
          <p class="mb-1 mt-2 text-dark fw-bold">{{ $product->name }}</p>
          <h5 class="text-primary fw-bold">{{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}</h5>
        </a>          
        @endforeach
    </div>
</div>
@endsection