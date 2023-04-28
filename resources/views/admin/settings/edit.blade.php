@extends("admin.base")

@section("head")
<title>Edit Settings</title>
@endsection

@section("content")
<div class="card mx-auto max-w-3xl">
    <div class="card-header card-header-title">Edit Setting</div>

    <form action="/admin/settings" class="card-body" method="post">
        @csrf 
        @method("patch")

        <div class="form-group">
            <label for="about" class="form-label">About</label>

            <input 
                type="text" 
                name="about" 
                id="about" 
                value="{{ $setting->about }}" 
                class="form-control {{ $errors->has("name") ? "form-control-error" : "" }}"
            >

            @error("about")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="mobile" class="form-label">Mobile</label>

            <input 
                type="text" 
                name="mobile" 
                id="mobile" 
                value="{{ $setting->mobile }}" 
                class="form-control {{ $errors->has("mobile") ? "form-control-error" : "" }}"
            >

            @error("mobile")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email</label>

            <input 
                type="email" 
                name="email" 
                id="email" 
                value="{{ $setting->email }}" 
                class="form-control {{ $errors->has("email") ? "form-control-error" : "" }}"
            >

            @error("email")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="gst" class="form-label">Gst</label>

            <input 
                type="number" 
                name="gst" 
                id="gst" 
                value="{{ $setting->gst }}" 
                class="form-control {{ $errors->has("gst") ? "form-control-error" : "" }}"
            >

            @error("gst")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="shippingCost" class="form-label">Shipping Cost</label>

            <input 
                type="number" 
                name="shipping_cost" 
                id="shippingCost" 
                value="{{ $setting->shipping_cost }}" 
                class="form-control {{ $errors->has("shipping_cost") ? "form-control-error" : "" }}"
            >

            @error("shipping_cost")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="returnAddress" class="form-label">Return Address</label>

            <input 
                type="number" 
                name="return_address" 
                id="returnAddress" 
                value="{{ $setting->return_address }}" 
                class="form-control {{ $errors->has("return_address") ? "form-control-error" : "" }}"
            >

            @error("return_address")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection