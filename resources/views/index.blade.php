@extends("base")

@section("head")
    <title>Home</title>
@endsection

@section("content")
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <img src="{{ $sliders[0]->image }}" class="w-full block object-cover">
    </div>

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
@endsection