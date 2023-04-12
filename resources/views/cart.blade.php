@extends('base')

@section('content')
<div class="container my-4 px-2">
    @if (count($cartItems) == 0)
    <div class="alert alert-warning">Your Cart Is Empty</div>
    @else
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header fw-bold text-primary">Cart Products</div>
                <div class="card-body">
                    @foreach ($cartItems as $cartItem)
                    <div data-cart-item='@json($cartItem)' class="row gx-2 gx-md-3 pt-3 mt-3 border-top cart-item">
                        <div class="col-3 col-md-2">
                            <img src="{{ $cartItem->image_url }}" class="img-fluid">
                        </div>
                        <div class="col-9 col-md-10" style="flex: 1">
                            <div class="row g-0">
                                <div class="col-8">
                                    <h2 class="fw-bold h6">{{ $cartItem->name }}</h2>
                                    @if (!$cartItem->in_stock)
                                        <div class="text-danger">This product is currently out of stock</div>
                                    @endif
                                    <p class="fw-bold text-primary my-3">Rs. <span class="price">{{ $cartItem->price }}</span></p>
                                    <button id="remove" class="btn btn-warning d-flex align-items-center gap-2 btn-sm">
                                        <span class="material-icons" style="font-size: 18px;">close</span>
                                        <span>Remove</span>
                                    </button>
                                </div>
                                <div class="col-4">
                                    <label class="w-bold text-primary mb-1 d-inline-block fw-bold" style="font-size: 14px;">Quantity</label>
                                    <input type="number" class="quantity form-control" value="{{ $cartItem->quantity}}">
                                    <button class="update">Update</button>
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
                {{-- <div class="card-body">
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
                </div> --}}
                <div class="card-footer text-end">
                    <button class="btn btn-primary">Checkout</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    $("button.update").click(function() {
        const cartItem = JSON.parse($(this).closest("div[data-cart-item]").attr("data-cart-item"))

        const quantity = $(this).parent().find(".quantity").val()

        fetch("/cart/" + cartItem.product_id + "?_method=PATCH", {
                method: "post",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    quantity,
                    variation_id: cartItem.variation_id
                })
            })
            .then(async (response) => {
                if(response.status === 200) {
                    alert((await response.json()).success)
                } else {
                    alert((await response.json()).error)
                }
            })
    })
    $("button[id=remove]").click(function() {
        const cartItem = JSON.parse($(this).closest("div[data-cart-item]").attr("data-cart-item"))

        fetch("/cart?_method=DELETE", {
            method: "POST",
            headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    product_id: cartItem.product_id,
                    variation_id: cartItem.variation_id
                })
        })
        .then(async response => {
            console.log(await response.json());
            window.location.reload()
        })
    })



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