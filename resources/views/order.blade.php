@extends("base")

@section("head")
    <title>Order</title>
@endsection

@section("content")
<div class="grid grid-cols-12 gap-6 max-w-7xl mx-auto items-start">
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
                        @foreach ($order->products as $product)
                            <tr>
                                <td>
                                    <div class="flex gap-3 items-center">
                                        <img src="/uploads/{{ $product->image }}" class="w-14 h-14 object-cover">
                                        <p>{{ $product->name }}</p>
                                    </div>
                                </td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-4">
        <div class="card">
            <div class="card-header card-header-title">Payment Details</div>
            <div class="card-body">
                <p class="flex items-center justify-between border-b border-gray-300 pb-3 mb-3">
                    <span>Product Price</span>
                    <span>₹ {{ $order->paymentDetails->product_price }}</span>
                </p>
                <p class="flex items-center justify-between border-b border-gray-300 pb-3 mb-3">
                    <span>Gst ({{ $order->paymentDetails->gst }}%)</span>
                    <span>₹ {{ $order->paymentDetails->gst_amount }}</span>
                </p>
                <p class="flex items-center justify-between border-b border-gray-300 pb-3 mb-3">
                    <span>Shipping Cost</span>
                    <span>₹ {{ $order->paymentDetails->shipping_cost }}</span>
                </p>
                <p class="flex items-center justify-between">
                    <span>Total Payable</span>
                    <span>₹ {{ $order->paymentDetails->total_amount }}</span>
                </p>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header card-header-title">Shipping Address</div>
            <div class="card-body">
                <p class="border-b border-gray-300 pb-3 mb-3">Name - {{ $order->shippingAddress->name }}</p>
                <p class="border-b border-gray-300 pb-3 mb-3">Mobile - {{ $order->shippingAddress->mobile }}</p>
                <p>Address - {{ $order->shippingAddress->address }}</p>
            </div>
        </div>
    </div>
</div>
@endsection