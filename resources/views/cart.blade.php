@extends('base')

@section('content')
<div class="container my-4 px-2">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header fw-bold text-primary">Cart Products</div>
                <div class="card-body">
                    <div class="row gx-2 gx-md-3">
                        <div class="col-3 col-md-2">
                            <img src="/uploads/images/products/Thumbnail/t-2.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-9 col-md-10" style="flex: 1">
                            <div class="row g-0">
                                <div class="col-8">
                                    <h2 class="fw-bold h6">Men's slim fit tshirt</h2>
                                    <p class="fw-bold text-primary my-3">Rs. 345</p>
                                    <button class="btn btn-warning d-flex align-items-center gap-2 btn-sm">
                                        <span class="material-icons" style="font-size: 18px;">close</span>
                                        <span>Remove</span>
                                    </button>
                                </div>
                                <div class="col-4">
        
                                    <label for="" class="w-bold text-primary mb-1 d-inline-block fw-bold" style="font-size: 14px;">Quantity</label>

                                    <input type="number" class="form-control" value="1">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-2 gx-md-3 pt-3 mt-3 border-top">
                        <div class="col-3 col-md-2">
                            <img src="/uploads/images/products/Thumbnail/t-2.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-9 col-md-10">
                            <div class="row g-0">
                                <div class="col-8">
                                    <h2 class="fw-bold h6">Men's slim fit tshirt</h2>
                                    <p class="fw-bold text-primary my-3">Rs. 345</p>
                                    <button class="btn btn-warning d-flex align-items-center gap-2 btn-sm">
                                        <span class="material-icons" style="font-size: 18px;">close</span>
                                        <span>Remove</span>
                                    </button>
                                </div>
                                <div class="col-4">
        
                                    <label for="" class="w-bold text-primary mb-1 d-inline-block fw-bold" style="font-size: 14px;">Quantity</label>

                                    <input type="number" class="form-control" value="1">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-secondary btn-sm">Save changes</button>
                    <button class="btn btn-danger btn-sm">Remove all</button>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mt-4 mt-md-0">
                <div class="card-header fw-bold text-primary">Pricing Details</div>
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
                <div class="card-footer text-end">
                    <button class="btn btn-primary">
                        <span>Checkout</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection