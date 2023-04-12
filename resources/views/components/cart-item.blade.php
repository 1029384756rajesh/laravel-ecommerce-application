<div data-cart-item='@json($cartItem)' class="d-flex gap-3 pt-3 mt-3 border-top cart-item">
    <img src="{{ $cartItem->image_url }}" class="img-fluid" style="height:100px;width:100px;object-fit:cover">

    <div class="row g-0" style="flex:1">
        <div class="col-12 col-md-7 col-lg-8">
            <h6 class="fw-bold mb-0">{{ $cartItem->name }}</h6>

            @if (!$cartItem->in_stock) <p class="text-danger mt-2 mb-0">This product is currently out of stock</p> @endif

            <p class="fw-bold text-primary mt-2 mb-0">₹ {{ $cartItem->price }}</p>

            <button class="btn btn-warning btn-sm mt-2 remove">Remove</button>
        </div>

        <div class="col-12 col-md-5 col-lg-4 mt-2 mt-md-0">
            <label class="w-bold text-primary mb-1 d-inline-block fw-bold" style="font-size: 14px;">Quantity</label>

            <div class="input-group">
                <input type="number" class="quantity form-control" value="{{ $cartItem->quantity}}">
                <button class="btn btn-outline-secondary update" type="button"><i class="fa-solid fa-check"></i></button>
            </div>  
        </div>
    </div>
</div>