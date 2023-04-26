@extends("admin.base")

@section("head")
<title>Order Details</title>
@endsection

@section("content")
<div class="container my-4 px-2">
    <div class="grid grid-cols-12 gap-4 items-start">
        <div class="col-span-8 card">
            <div class="card-header text-indigo-600 font-bold">Products</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered min-w-[700px]">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $product)   
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $product->image_url }}" height="70px" width="70px" class="img-fluid">
                                            <div>{{ $product->name }}</div>
                                        </div>
                                    </td>
                                    <td>₹ {{ $product->price }}</td>
                                    <td>{{ $product->quantity }}</td>
                                </tr>                  
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-span-4 space-y-4">
            <div class="card">
                <div class="card-header text-indigo-600 font-bold">Payment Details</div>
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
            <div class="card">
                <div class="card-header text-indigo-600 font-bold">Shipping Address</div>
                <div class="card-body">
                    <p class="border-b border-gray-300 pb-3 mb-3">Name - {{ $order->shippingAddress->name }}</p>
                    <p class="border-b border-gray-300 pb-3 mb-3">Mobile - {{ $order->shippingAddress->mobile }}</p>
                    <p>Address - {{ $order->shippingAddress->address }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header text-indigo-600 font-bold">Status</div>
                <div class="card-body">
                    <form method="post" action="/admin/orders/{{ $order->id }}" class="flex">
                        @csrf @method("patch")
                        <select name="status" id="status" class="form-select rounded-r-none form-control">
                            <option {{ $order->status == "Placed" ? "selected" : "" }} value="Placed">Placed</option>
                            <option {{ $order->status == "Accepted" ? "selected" : "" }} value="Accepted">Accepted</option>
                            <option {{ $order->status == "Rejected" ? "selected" : "" }} value="Rejected">Rejected</option>
                            <option {{ $order->status == "Canceled" ? "selected" : "" }} value="Canceled">Canceled</option>
                            <option {{ $order->status == "Delivered" ? "selected" : "" }} value="Delivered">Delivered</option>
                        </select>                        
                        <button class="btn btn-primary rounded-l-none" type="submit" id="button-addon2"><i class="fa fa-check"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection