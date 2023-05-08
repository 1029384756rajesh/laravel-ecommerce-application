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
                                            
                                            <button class="btn-update btn btn-outline-secondary rounded-l-none">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn-delete btn btn-outline-secondary">
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
    $(".btn-delete").click(async function() {
        const productId = $(this).closest("tr").attr("data-id")
        
        const response = await fetch(`/cart/${productId}?_method=delete`, {
            method: "post",
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })

        if(response.status === 200) {
            alert((await response.json()).success)
            window.location.reload()
        } else {
            alert("Sorry, An unknown error occur")
        }
    })

    $(".btn-update").click(async function() {
        const productId = $(this).closest("tr").attr("data-id")
        const quantity = $(this).parent().find("input").val()
        
        const response = await fetch(`/cart/${productId}`, {
            method: "post",
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({quantity})
        })

        if(response.status === 200) {
            alert((await response.json()).success)
            window.location.reload()
        } else if(response.status === 422) {
            alert((await response.json()).error)
        } else {
            alert("Sorry, An unknown error occur")
        }
    })
</script>
@endsection