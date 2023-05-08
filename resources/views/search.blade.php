@extends("base")

@section("content")
<div class="max-w-7xl mx-auto px-3">
    <form class="card mx-auto mb-4 max-w-2xl">
        <div class="card-header card-header-title">Search</div>
        <div class="card-body">
            <div class="flex">
                <input name="search" type="search" value="{{ Request::get("search") }}" class="form-control rounded-r-none">
                <button type="submit" class="btn btn-outline-secondary rounded-l-none">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3" >
        @foreach ($products as $product)
            <a href="/products/{{ $product->id }}" class="text-center">
              <img src="{{ $product->image }}" class="w-full object-cover">
              <p class="mt-2 mb-1 font-semibld font-medium">{{ $product->name }}</p>
              <h5 class="text-lg font-bold text-indigo-600">{{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}</h5>
            </a>          
      @endforeach
      </div>
</div>
@endsection