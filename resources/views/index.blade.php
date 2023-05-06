@extends('base')

@section('content')
<div class="container">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js" integrity="sha512-Gfrxsz93rxFuB7KSYlln3wFqBaXUc1jtt3dGCp+2jTb563qYvnUBM/GP2ZUtRC27STN/zUamFtVFAIsRFoT6/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<link rel="stylesheet" href="/assets/lightslider.css">


<div class="px-3">
  <div class="max-w-7xl mx-auto mb-4 overflow-hidden flex gap-0 bg-red-600 relative">
    <button class="absolute left-4 top-1/2 translate-y-1/2 rounded-full bg-white w-10 h-10 flex items-center justify-center">
      <div class="fa fa-arrow-left"></div>
    </button>
    <button class="absolute right-4 top-1/2 translate-y-1/2 rounded-full bg-white w-10 h-10 flex items-center justify-center">
      <div class="fa fa-arrow-right"></div>
    </button>
    {{-- <button class="fa fa-arrow-right"></button> --}}
    @foreach ($sliders as $slider)
    
            <img src="{{ $slider->image }}" class="w-full block {{ $loop->index == 3 ? "translate-x-[300%]" : ""}}">
     
    
    @endforeach
    </div>
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