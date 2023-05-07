@extends('base')

@section('content')
<div class="container">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js" integrity="sha512-Gfrxsz93rxFuB7KSYlln3wFqBaXUc1jtt3dGCp+2jTb563qYvnUBM/GP2ZUtRC27STN/zUamFtVFAIsRFoT6/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<link rel="stylesheet" href="/assets/lightslider.css">


<div class="owl-carousel">
  @foreach ($sliders as $slider)
  
<div>
<img src="{{ $slider->image }}" class="w-full block {{ $loop->index == 3 ? "translate-x-[300%]" : ""}}">

</div>

@endforeach
 </div>

  <div class="max-w-7xl mx-auto px-3 ">
    @foreach ($categories as $category)
    <div class="border-b-2 mb-8 border-indigo-600">
      <p class="bg-indigo-600 text-white inline-block px-4 py-1 rounded-t-md text-lg">{{ $category->name }}</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3" >
      @foreach ($category->products as $product)
          <a href="/products/{{ $product->id }}" class="text-center">
            <img src="{{ $product->image }}" class="w-full object-cover">
            <p class="mt-2 mb-1 font-semibld font-medium">{{ $product->name }}</p>
            <h5 class="text-lg font-bold text-indigo-600">{{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}</h5>
          </a>          
    @endforeach
    </div>
    @endforeach
  </div>
</div>
<script>
  $(document).ready(function() {
    $('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})
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
@endsection