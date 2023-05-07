@extends('base')

@section('content')
<form action="/orders" method="poST">
@csrf

<div class="container my-4 px-2">
    <div class="max-w-6xl mx-auto grid grid-cols-12 items-start gap-6">
        <div class="col-span-12 lg:col-span-8">
            <div class="card">
                <div class="card-header card-header-title">Shipping Address</div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>

                        <input type="text" name="name" id="name" value="{{ old("name") }}" class="form-control {{ $errors->has("name") ? "form-control-error" : "" }}">
                    
                        @error("name")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="mobile" class="form-label">Mobile</label>

                        <input type="text" name="mobile" id="mobile" value="{{ old("mobile") }}" class="form-control {{ $errors->has("mobile") ? "form-control-error" : "" }}">
                    
                        @error("mobile")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="addressLine1" class="form-label">Address line 1</label>

                        <input type="text" name="address_line_1" id="addressLine1" value="{{ old("address_line_1") }}" class="form-control {{ $errors->has("address_line_1") ? "form-control-error" : "" }}">
                    
                        @error("address_line_1")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="addressLine2" class="form-label">Address line 2</label>

                        <input type="text" name="address_line_2" id="addressLine2" value="{{ old("address_line_2") }}" class="form-control {{ $errors->has("address_line_2") ? "form-control-error" : "" }}">
                    
                        @error("address_line_2")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="city" class="form-label">City</label>

                        <input type="text" name="city" id="city" value="{{ old("city") }}" class="form-control {{ $errors->has("city") ? "form-control-error" : "" }}">
                    
                        @error("city")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="state" class="form-label">State</label>

                        <input type="text" name="state" id="state" value="{{ old("state") }}" class="form-control {{ $errors->has("state") ? "form-control-error" : "" }}">
                    
                        @error("state")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pincode" class="form-label">Pincode</label>

                        <input type="text" name="pincode" id="pincode" value="{{ old("pincode") }}" class="form-control {{ $errors->has("pincode") ? "form-control-error" : "" }}">
                    
                        @error("pincode")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                   
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input">
                        <label for="save" class="form-label">Save This Address</label>
                    </div>

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
        <div class="col-span-12 lg:col-span-4 card">
            <div class="card-header card-header-title">Pricing Details</div>
            <div class="card-body">
                <p class="flex items-center justify-between border-b border-gray-300 pb-3 mb-3">
                    <span>Product Price</span>
                    <span>Rs {{ $product_price }}</span>
                </p>
                <p class="flex items-center justify-between border-b border-gray-300 pb-3 mb-3">
                    <span>Gst ({{ $gst }}%)</span>
                    <span>Rs {{ $gst_amount }}</span>
                </p>
                <p class="flex items-center justify-between border-b border-gray-300 pb-3 mb-3">
                    <span>Shipping Cost</span>
                    <span>Rs {{ $shipping_cost }}</span>
                </p>
                <p class="flex items-center justify-between">
                    <span>Total Payable</span>
                    <span>Rs {{ $total_amount }}</span>
                </p>
            </div>
            <form action="/orders" method="post" class="card-footer text-end block">
                @csrf

                <button type="submit" class="btn btn-primary">Place Order</button>
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