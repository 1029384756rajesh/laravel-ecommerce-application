@extends("base")

@section("head")
    <title>Checkout</title>
@endsection

@section("content")
<form action="/orders" method="post" class="container my-4 px-2">
    @csrf
    
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

                    <div>
                        <label for="pincode" class="form-label">Pincode</label>

                        <input type="text" name="pincode" id="pincode" value="{{ old("pincode") }}" class="form-control {{ $errors->has("pincode") ? "form-control-error" : "" }}">
                    
                        @error("pincode")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
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
            <div class="card-footer text-end block">
                <button type="submit" class="btn btn-primary">Place Order</button>
            </div>
        </div>
    </div>
</form>
@endsection