@extends("base")

@section("content")
<div class="max-w-7xl mx-auto px-3">
    <form class="card mx-auto mb-4 max-w-2xl">
        <div class="card-header card-header-title">Search</div>
        <div class="card-body">
            <div class="flex">
                <input name="search" type="search" class="form-control rounded-r-none">
                <button type="submit" value="" class="btn btn-outline-secondary rounded-l-none">
                    <i class="fa fa-search"></i>
                </button>
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
@endsection