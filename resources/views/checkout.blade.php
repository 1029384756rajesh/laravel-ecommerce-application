@extends('base')

@section('content')
<form action="/orders" method="poST">
@csrf

<div class="container my-4 px-2">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-primary">Shipping Address</span>
                    <a href="" class="btn btn-sm btn-primary">Add New</a>
                </div>
                <div class="card-body">
                    <x-form-control type="text" name="name" label="Name" id="name"/>

                    <x-form-control type="number" name="mobile" label="Mobile" id="mobile"/>

                    <x-form-control type="text" name="address_line_1" label="Address Line 1" id="address_line_1"/>

                    <x-form-control type="text" name="address_line_2" label="Address Line 2" id="address_line_2"/>

                    <x-form-control type="text" name="city" label="City" id="city"/>

                    <x-form-control type="number" name="pincode" label="Pincode" id="pincode"/>

                    <x-form-check name="next_time" label="Save Address"/>

                    {{-- <label class="d-flex gap-4 align-items-center" style="cursor: pointer">
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
                    </label> --}}
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mt-3 mt-md-0">
                <div class="card-header fw-bold text-primary">Pricing Details</div>
                <div class="card-body">
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Product Price</span>
                        <span>Rs {{ $product_price }}</span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Gst ({{ $gst }}%)</span>
                        <span>Rs {{ $gst_amount }}</span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between border-bottom pb-2">
                        <span>Shipping Cost</span>
                        <span>Rs {{ $shipping_cost }}</span>
                    </p>
                    <p class="d-flex align-items-center justify-content-between mb-0">
                        <span>Total Payable</span>
                        <span>Rs {{ $total_amount }}</span>
                    </p>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary">Place Order</button>
                </div>
            </div>
        </div>
    </div>


</div>
</form>

<script>
    $("input[name=next_time].form-check-input").change(function() {

        const shippingAddress = {}

        if($(this).is(":checked"))
        {
            shippingAddress.name = $("input[name=name]").val(),
            shippingAddress.mobile = $("input[name=mobile]").val(),
            shippingAddress.address_line_1 = $("input[name=address_line_1]").val(),
            shippingAddress.address_line_2 = $("input[name=address_line_2]").val(),
            shippingAddress.city = $("input[name=city]").val(),
            shippingAddress.pincode = $("input[name=pincode]").val()
        }
        
        localStorage.setItem("shippingAddress", JSON.stringify(shippingAddress));
    })

    const shippingAddress = JSON.parse(localStorage.getItem("shippingAddress"))

    if(shippingAddress)
    {
        $("input[name=name]").val(shippingAddress.name)
        $("input[name=mobile]").val(shippingAddress.mobile)
        $("input[name=address_line_1]").val(shippingAddress.address_line_1)
        $("input[name=address_line_2]").val(shippingAddress.address_line_2)
        $("input[name=city]").val(shippingAddress.city)
        $("input[name=pincode]").val(shippingAddress.pincode)
    }
</script>
@endsection