@extends('admin.base')

@section('content')
<div class="container my-4 px-2">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header fw-bold text-primary">Products</div>
                <div class="card-body">
                    @foreach ($order->products as $product)
                    <div class="d-flex gap-3">
                        <img src="{{ $product->image_url }}" style="height: 120px; width: 120px; object-fit: cover;" class="img-fluid" alt="">
                        <div>
                            <h4 class="h6 fw-bold">{{ $product->name }}</h4>
                            <h3 class="fw-bold text-primary h5 my-3">Rs. {{ $product->price }}</h3>
                            <p>Quantity - {{ $product->quantity }}</p>
                        </div>
                    </div>                        
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mt-3 mt-md-0">
                <div class="card-header fw-bold text-primary">Payment Details</div>
                <div class="card-body">
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Product Price</span>
                        <span>Rs {{ $order->paymentDetails->product_price }}</span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Gst ({{ $order->paymentDetails->gst }}%)</span>
                        <span>Rs {{ $order->paymentDetails->gst_amount }}</span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Shipping Cost</span>
                        <span>Rs {{ $order->paymentDetails->shipping_cost }}</span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between mb-0">
                        <span>Total Payable</span>
                        <span>Rs {{ $order->paymentDetails->total_amount }}</span>
                    </p>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header fw-bold text-primary">Shipping Address</div>
                <div class="card-body">
                    <p>Name - {{ $order->shippingAddress->name }}</p>
                    <p>Mobile - {{ $order->shippingAddress->mobile }}</p>
                    <p class="mb-0">Address - {{ $order->shippingAddress->address }}</p>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header fw-bold text-primary">Status</div>
                <div class="card-body">
                    <form method="POST" action="/admin/orders/{{ $order->id }}" class="input-group">
                        @csrf
                        @method("patch")
                        <select name="status" id="status" class="form-select form-control">
                            <option {{ $order->status == "Placed" ? "selected" : "" }} value="Placed">Placed</option>
                            <option {{ $order->status == "Accepted" ? "selected" : "" }} value="Accepted">Accepted</option>
                            <option {{ $order->status == "Rejected" ? "selected" : "" }} value="Rejected">Rejected</option>
                            <option {{ $order->status == "Canceled" ? "selected" : "" }} value="Canceled">Canceled</option>
                            <option {{ $order->status == "Delivered" ? "selected" : "" }} value="Delivered">Delivered</option>
                        </select>                        
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fa fa-check"></i></button>
                      </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection