@extends('base')

@section('content')
<div class="container my-4 px-3">
    <div class="row">
        <div class="col-12 col-md-4">
            <img src="/uploads/{{ $product->image_url }}" style="width: 100%" class="img-fluid" id="main_img">
            <div class="row g-2 mt-2">
                <div class="col-3">
                    <img src="/uploads/{{ $product->image_url }}" style="width: 100%" class="img-fluid">
                </div>   
                @foreach ($product->images as $image)
                <div class="col-3">
                    <img onclick="changeImage(event)" src="/uploads/{{ $image->image_url }}" style="width: 100%" class="img-fluid" alt="">
                </div>                    
                @endforeach
            </div>
        </div>
        <div class="col-12 col-md-8">
            <h2 class="h4 fw-bold mt-4 mt-md-0">{{ $product->name }}</h2>
            <p class="text-muted">{{ $product->short_description }}</p>
            <div class="d-flex gap-1">
                <span class="material-icons text-warning h5">star</span>
                <span class="material-icons text-warning h5">star</span>
                <span class="material-icons text-warning h5">star</span>
                <span class="material-icons text-warning h5">star</span>
                <span class="material-icons text-muted h5">star</span>
            </div>
            <h4 class="fw-bold text-primary mt-2">Rs. {{ $product->price }}</h4>
            <div class="d-flex align-items-center gap-2 mt-3">
                <label for="quantity" class="form-label fw-semibold">Quantity : </label>
            <input type="number" name="quantity" id="quantity" value="1" class="form-control" style="max-width: 150px;">
            </div>
            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary d-flex align-items-center gap-2" onclick="addToCart(event, {{ $product->id }})">
                    <span class="material-icons" style="font-size: 20px;">shopping_cart</span>
                    <span>Add to cart</span>
                </button>
                <button class="btn btn-danger d-flex align-items-center gap-2" onclick="addToWishlist(event, {{ $product->id }})">
                    <span class="material-icons" style="font-size: 20px;">favorite</span>
                    <span>Wishlist</span>
                </button>
            </div>

            <h4 class="fw-bold text-info h6 mt-4">Long Description</h4>
            <p class="text-muted">{{ $product->long_description }}</p>
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-primary">Reviews</span>
                    <button class="btn btn-sm btn-primary">Add Review</button>
                </div>
                <div class="card-body">
                    @if (count($product->reviews) == 0)
                        <div class="alert alert-warning">No Reviews Found</div>
                    @endif
                    @foreach ($product->reviews as $review)
                    <div>
                        <h6 class="fw-semibold">{{ $review->name }}</h6>
                        <div class="d-flex">
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-muted h6">star</span>
                        </div>
                        <p class="text-muted">{{ $review->pivot->review }}</p>
                        @if ($review->id == auth()->user()->id)
                        <button class="btn btn-sm btn-warning">Delete</button>
                        @endif
                    </div>
                    @endforeach
           
                    <div class="mt-3 pt-3 border-top">
                        <h6 class="fw-semibold">Gay Baudain</h6>
                        <div class="d-flex">
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-muted h6">star</span>
                        </div>
                        <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores nisi facere necessitatibus! Rerum iste dolorum natus beatae, quisquam ut perferendis!</p>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <h6 class="fw-semibold">John Doe</h6>
                        <div class="d-flex">
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-muted h6">star</span>
                        </div>
                        <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores nisi facere necessitatibus! Rerum iste dolorum natus beatae, quisquam ut perferendis!</p>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <h6 class="fw-semibold">Todd Domoni</h6>
                        <div class="d-flex">
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-warning h6">star</span>
                            <span class="material-icons text-muted h6">star</span>
                        </div>
                        <p class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores nisi facere necessitatibus! Rerum iste dolorum natus beatae, quisquam ut perferendis!</p>
                        <button class="btn btn-sm btn-warning">Delete</button>
                    </div>
                </div>
                <div class="card-footer">
                    <nav class="text-end" aria-label="orders page navigation">
                        <ul class="pagination mb-0 d-inline-flex">
                          <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                              <span aria-hidden="true">&laquo;</span>
                            </a>
                          </li>
                          <li class="page-item"><a class="page-link" href="#">1</a></li>
                          <li class="page-item"><a class="page-link" href="#">2</a></li>
                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                          <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                              <span aria-hidden="true">&raquo;</span>
                            </a>
                          </li>
                        </ul>
                      </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function changeImage(event) {
        const mainImageElement = document.querySelector("#main_img")

        mainImageElement.src = event.target.src
    }

    async function addToCart(event, productId) {
        event.target.disabled = true 

        const quantity = Number(document.querySelector("#quantity").value)

        const response = await fetch("{{ route('cart.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({product_id: productId, quantity})
        })

        if(response.status === 409) {

            const { error } = await response.json()

            alert(error)

        }  else if (response.status === 200) {
            const { success } = await response.json()

            alert(success)
        }

        event.target.disabled = false 
    }

    async function addToWishlist(event, productId) {
        event.target.disabled = true 

        const response = await fetch("{{ route('wishlists.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({product_id: productId})
        })

        if(response.status === 409) {

            const { error } = await response.json()

            alert(error)

        }  else if (response.status === 200) {
            const { success } = await response.json()

            alert(success)
        }

        event.target.disabled = false 
    }
</script>
@endsection