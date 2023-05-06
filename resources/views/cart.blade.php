@extends("base")

@section("head")
    <title>Cart</title>
@endsection

@section("content")
<div class="container my-4 px-2">
    @if (count($products) == 0) 
        <div class="alert alert-warning">Your Cart Is Empty</div> 
    @else

    <div class="max-w-7xl mx-auto px-3 grid grid-cols-12 gap-6 items-start">
        <div class="col-span-12 lg:col-span-8 card">
            <div class="card-header card-header-title">Products</div>
            <div class="card-body">
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr data-id="{{ $product->id }}">
                                    <td>
                                        <div class="flex gap-3 items-center">
                                            <img src="{{ $product->image }}" class="w-14 h-14 object-cover">
                                            <p>{{ $product->name }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex">
                                            <input type="text" name="quantity" class="form-control max-w-[100px] rounded-r-none" value="{{ $product->quantity }}">
                                            
                                            <button class="update btn btn-outline-secondary rounded-l-none">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="remove btn btn-outline-secondary">
                                            <i class="fa fa-close"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-4 card">
            <div class="card-header card-header-title">Pricing Details</div>
            <div class="card-body">
                <p class="flex items-center justify-between border-b border-gray-300 pb-3 mb-3">
                    <span>Product Price</span>
                    <span>₹ {{ $product_price }}</span>
                </p>
                <p class="flex items-center justify-between border-b border-gray-300 pb-3 mb-3">
                    <span>Gst (<span id="gst">{{ $gst }}</span>%)</span>
                    <span>₹ {{ $gst_amount }}</span>
                </p>
                <p class="flex items-center justify-between border-b border-gray-300 pb-3 mb-3">
                    <span>Shipping Cost</span>
                    <span>₹ {{ $shipping_cost }}</span>
                </p>
                <p class="flex items-center justify-between">
                    <span>Total Payable</span>
                    <span>₹ {{ $total_amount }}</span>
                </p>
            </div>
            <div class="card-footer flex justify-end">
                <a href="/checkout" class="btn btn-primary">Checkout</a>
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