@extends('base')

@section('content')
<div class="container my-4 px-2">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-primary">Select your address</span>
                    <a href="" class="btn btn-sm btn-primary">Add New</a>
                </div>
                <div class="card-body">
                    <label class="d-flex gap-4 align-items-center" style="cursor: pointer">
                        <input type="radio" name="address_id" class="form-check-input">
                        <div>
                            <p>
                                <span class="fw-bold">Full Name - </span>
                                <span>Rajesh Rout</span>
                            </p>
                            <p>
                                <span class="fw-bold">Mobile - </span>
                                <span>5678754566</span>
                            </p>
                            <p>
                                <span class="fw-bold">Address line 1 - </span>
                                <span>Jayanagar, 3rd corss, 3rd phase</span>
                            </p>
                            <p>
                                <span class="fw-bold">Address line 2 - </span>
                                <span>Near l.n public school</span>
                            </p>
                            <p>
                                <span class="fw-bold">City - </span>
                                <span>Banglore</span>
                            </p>
                            <p class="mb-0">
                                <span class="fw-bold">Pincode - </span>
                                <span>455555</span>
                            </p>
                        </div>
                    </label>
                    <label class="d-flex gap-4 align-items-center pt-3 mt-3 border-top" style="cursor: pointer">
                        <input type="radio" name="address_id" class="form-check-input">
                        <div>
                            <p>
                                <span class="fw-bold">Full Name - </span>
                                <span>Rajesh Rout</span>
                            </p>
                            <p>
                                <span class="fw-bold">Mobile - </span>
                                <span>5678754566</span>
                            </p>
                            <p>
                                <span class="fw-bold">Address line 1 - </span>
                                <span>Jayanagar, 3rd corss, 3rd phase</span>
                            </p>
                            <p>
                                <span class="fw-bold">Address line 2 - </span>
                                <span>Near l.n public school</span>
                            </p>
                            <p>
                                <span class="fw-bold">City - </span>
                                <span>Banglore</span>
                            </p>
                            <p class="mb-0">
                                <span class="fw-bold">Pincode - </span>
                                <span>455555</span>
                            </p>
                        </div>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mt-3 mt-md-0">
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
                    <button class="btn btn-primary">Place Order</button>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection