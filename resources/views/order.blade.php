@extends('base')

@section('content')
<div class="container my-4 px-2">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header fw-bold text-primary">Products</div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <img src="/uploads/images/products/Thumbnail/t-1.png" style="height: 120px; width: 120px; object-fit: cover;" class="img-fluid" alt="">
                        <div>
                            <h4 class="h6 fw-bold">Men's slim fit tshirt</h4>
                            <h3 class="fw-bold text-primary h5 my-3">Rs. 456</h3>
                            <p>Quantity - 4</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 pt-3 mt-3 border-top">
                        <img src="/uploads/images/products/Thumbnail/t-1.png" style="height: 120px; width: 120px; object-fit: cover;" class="img-fluid" alt="">
                        <div>
                            <h4 class="h6 fw-bold">Men's slim fit tshirt</h4>
                            <h3 class="fw-bold text-primary h5 my-3">Rs. 456</h3>
                            <p>Quantity - 4</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mt-3 mt-md-0">
                <div class="card-header fw-bold text-primary">Payment Details</div>
                <div class="card-body">
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Product Price</span>
                        <span>Rs 345</span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Gst (7%)</span>
                        <span>Rs 34</span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Shipping Cost</span>
                        <span>Rs 344</span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between mb-0">
                        <span>Total Payable</span>
                        <span>Rs 567</span>
                    </p>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header fw-bold text-primary">Shipping Address</div>
                <div class="card-body">
                    <p>Name - Rajesh Rout</p>
                    <p>Mobile - 7684948575</p>
                    <p class="mb-0">Address - J.P Nagar, 3rd cross, Near Axis Bank, Banglore, 455001</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection