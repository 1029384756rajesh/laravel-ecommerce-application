@extends("base")

@section("content")

<div class="container my-4 px-2">
    
    @if (count($cartItems) == 0) <div class="alert alert-warning">Your Cart Is Empty</div> @else

    <div class="row">

        <div class="col-12 col-md-8">

            <div class="card">

                <div class="card-header fw-bold text-primary">Cart Products</div>

                <div class="card-body">
                    @foreach ($cartItems as $cartItem)

                    <x-cart-item :cartItem="$cartItem"/>

                    @endforeach
                </div>

            </div>

        </div>

        <div class="col-12 col-md-4">
            <div class="card mt-4 mt-md-0">
                <div class="card-header fw-bold text-primary">Pricing Details</div>
                <div class="card-body">
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Product Price</span>
                        <span>₹ {{ $product_price }}</span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Gst (<span id="gst">{{ $gst }}</span>%)</span>
                        <span>₹ {{ $gst_amount }}</span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Shipping Cost</span>
                        <span>₹ {{ $shipping_cost }}</span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between mb-0">
                        <span>Total Payable</span>
                        <span>₹ {{ $total_amount }}</span>
                    </p>
                </div>
                <div class="card-footer text-end">
                    <form action="/checkout" method="get">
                        @csrf
                        <button class="btn btn-primary">Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    $("button.update").click(function() {
        $(this).attr("disabled", true)

        const cartItem = JSON.parse($(this).closest("div[data-cart-item]").attr("data-cart-item"))

        const quantity = $(this).parent().find(".quantity").val()

        fetch(`/cart/${cartItem.product_id}?_method=PATCH`, {
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
            response.status === 200 ? alert((await response.json()).success) : alert((await response.json()).error)
            window.location.reload()
        })
        .finally(() => {
            $(this).attr("disabled", false)
        })
    })
    
    $("button.remove").click(function() {
        $(this).attr("disabled", true)

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
            response.status === 200 ? alert((await response.json()).success) : alert((await response.json()).error)
            window.location.reload()
        })
        .catch(() => {
            alert("Sorry, An unknown error occured")
        })
        .finally(() => {
            $(this).attr("disabled", false)
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