@extends('base')

@section('content')
<div class="container my-4 px-2">
    @if (count($cart) == 0)
    <div class="alert alert-warning">Your Cart Is Empty</div>
    @else
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header fw-bold text-primary">Cart Products</div>
                <div class="card-body">
                    @foreach ($cart as $cartItem)
                    <div class="row gx-2 gx-md-3 pt-3 mt-3 border-top cart-item">
                        <div class="col-3 col-md-2">
                            <img src="/uploads/{{ $cartItem->image_url }}" class="img-fluid">
                        </div>
                        <div class="col-9 col-md-10" style="flex: 1">
                            <div class="row g-0">
                                <div class="col-8">
                                    <h2 class="fw-bold h6">{{ $cartItem->name }}</h2>
                                    <p class="fw-bold text-primary my-3">Rs. <span class="price">{{ $cartItem->price }}</span></p>
                                    <button class="btn btn-warning d-flex align-items-center gap-2 btn-sm" onclick="removeProduct(event, {{ $cartItem->id }})">
                                        <span class="material-icons" style="font-size: 18px;">close</span>
                                        <span>Remove</span>
                                    </button>
                                </div>
                                <div class="col-4">
                                    <label class="w-bold text-primary mb-1 d-inline-block fw-bold" style="font-size: 14px;">Quantity</label>
                                    <input type="number" data-id="{{ $cartItem->id }}" class="quantity form-control" value="{{ $cartItem->pivot->quantity }}">
                                </div>
                            </div>
                        </div>
                    </div> 
                    @endforeach
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-secondary btn-sm" onclick="updateAll()">Save changes</button>
                    <button class="btn btn-danger btn-sm" onclick="removeAll()">Remove all</button>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mt-4 mt-md-0">
                <div class="card-header fw-bold text-primary">Pricing Details</div>
                <div class="card-body">
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Product Price</span>
                        <span>Rs <span id="product_price">{{ $product_price }}</span></span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Gst (<span id="gst">{{ $settings->gst }}</span>%)</span>
                        <span>Rs <span id="gst_amount">{{ $gst_amount }}</span></span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Shipping Cost</span>
                        <span>Rs <span id="delivery_fee">{{ $settings->delivery_fee }}</span></span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between mb-0">
                        <span>Total Payable</span>
                        <span>Rs <span id="total_amount">{{ $total_amount }}</span></span>
                    </p>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary">Checkout</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    async function removeProduct(event, productId) 
    {
        event.target.disabled = true 

        const response = await fetch("{{ route('cart.destroy') }}?_method=DELETE", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({product_id: productId})
        })

        if(response.status === 200)
        {
            event.target.closest(".cart-item").remove()

            const cartItemElements = document.querySelectorAll(".cart-item")

            if(cartItemElements.length == 0)
            {
                return window.location.href = "/"
            }
            
            updatePricing()

            alert("Product removed from cart successfully")
        }
        else 
        {
            alert("Sorry, An unknown error occur")   
            event.target.disabled = false
        }
    }

    async function removeAll() 
    {
        const response = await fetch("{{ route('cart.destroy.all') }}?_method=DELETE", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            }
        })

        if(response.status == 200)
        {
            alert("Your cart is empty now")
            window.location.href = "/"
        }
        else 
        {
            alert("Sorry, An unknonw error occur")
        }
    }

    async function updateAll() 
    {
        const items = []

        let invalid = false

        document.querySelectorAll(".quantity").forEach(element => {
            if(Number(element.value) <= 0)
            {
                invalid = true
            }

            items.push({product_id: Number(element.dataset.id), quantity: Number(element.value)})
        });

        if(invalid)
        {
            return alert("Invalid quantity");
        }

        const response = await fetch("{{ route('cart.update.all') }}?_method=PATCH", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({cartItems: items})
        })

        if(response.status === 200)
        {
            alert("Cart updated successfully")
            updatePricing()
        }
    }

    function validateQuantity(event) 
    {
        if(event.target.value == 1)
        {
            event.setCustomValidity("Invalid quantity")
        }    
        else 
        {
            event.setCustomValidity("")   
        }
    }

    function updatePricing() 
    {
        let productPrice = 0

        document.querySelectorAll(".cart-item").forEach(element => {
            const price = Number(element.querySelector('.price').innerHTML)
            const quantity = Number(element.querySelector('.quantity').value)
            productPrice = productPrice + (price * quantity)
        })

        const productPriceElement = document.querySelector("#product_price")

        const gstElement = document.querySelector("#gst")

        const gstAmountElement = document.querySelector("#gst_amount")

        const deliveryFeeElement = document.querySelector("#delivery_fee")

        const totalAmountElement = document.querySelector("#total_amount")

        const gst = Number(gstElement.innerHTML)

        const gstAmount = Number(gstAmountElement.innerHTML)

        const deliveryFee = Number(deliveryFeeElement.innerHTML)

        const newGstAmount = Math.round(productPrice * (gst / 100))

        const newTotalAmount = productPrice + deliveryFee + newGstAmount

        productPriceElement.innerHTML = productPrice

        totalAmountElement.innerHTML = newTotalAmount

        gstAmountElement.innerHTML = newGstAmount
    }
</script>
@endsection