@extends("base")

@section('content')
<div class="max-w-7xl mx-auto px-3 grid grid-cols-12 items-start gap-6">
    <form class="card col-span-12 lg:col-span-3">
        <div class="card-header card-header-title">Filter by category</div>
        <ul class="card-body -ml-3 space-y-4">
            <li>
                <a class="inline-block {{ Request::get("category_id") == null ? "text-indigo-800" : "" }}" href="/products">
                    <span class="inline-block ml-4">All @if(Request::get("category_id") == null) &#xbb; @endif</span>
                </a>
            </li>
            @foreach ($categories as $category)
                <li>
                    <a class="inline-block {{ $category->id == Request::get("category_id") ? "text-indigo-800" : "" }}" href="/products?category_id={{ $category->id }}">
                        <span style="margin-left: {{  $category->label * 12 }}px" class="inline-block">{{ $category->name }} @if($category->id == Request::get("category_id")) &#xbb; @endif</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </form>

    <div class="col-span-12 lg:col-span-9">
        @if (count($products) == 0)
            <div class="alert alert-warning">No Products Found</div>
        @endif
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3" >
            @foreach ($products as $product)
                <a href="/products/{{ $product->id }}" class="text-center">
                  <img src="{{ $product->image }}" class="w-full object-cover">
                  <p class="mt-2 mb-1 font-semibld font-medium">{{ $product->name }}</p>
                  <h5 class="text-lg font-bold text-indigo-600">{{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}</h5>
                </a>          
          @endforeach
          </div>
    </div>
</div>
@endsection