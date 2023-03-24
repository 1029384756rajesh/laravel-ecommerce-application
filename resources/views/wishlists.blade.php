@extends('base')

@section('content')
<div class="container my-4 px-2">
      <div class="card">
        <div class="card-header fw-bold text-primary">My Wishlist</div>
        <div class="card-body">
            @if (count($products) == 0)
                <div class="alert alert-warning">No Products In Wishlist</div>                
            @else
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 gy-4 gx-2">
                @foreach ($products as $product)
                <a href="{{ route('products.show', ['product' => $product->id]) }}" class="col text-decoration-none product">
                    <img src="/uploads/{{ $product->image_url }}" class="img-fluid">
                    <p class="mb-1 mt-2 text-dark">Men's slim fit tshirt</p>
                    <h5 class="text-primary fw-bold">Rs. 345</h5>
                    <button class="mt-1 btn btn-warning btn-sm" onclick="removeProduct(event, {{ $product->id }})">Remove</button>
                </a>                    
                @endforeach
            </div>
            @endif
        </div>
      </div>
</div>

<script>
    async function removeProduct(event, productId) 
    {
        event.preventDefault()
        event.stopPropagation()

        event.target.disabled = true

        
        const response = await fetch(`/wishlists/${productId}?_method=DELETE`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            }
        }) 

        if(response.status === 200)
        {
            const data = await response.json()
            alert(data.success)
            event.target.closest("a").remove()
            const products = document.querySelectorAll(".product")

            if(products.length == 0)
            {
                document.querySelector(".card-body").innerHTML = `
                <div class="alert alert-warning">No Products In Wishlist</div>
                `
            }
        }
        else 
        {
            alert("Sorry, Something went wrong")
        }
    }
</script>
@endsection