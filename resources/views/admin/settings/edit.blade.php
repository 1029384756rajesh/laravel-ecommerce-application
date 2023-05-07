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

            <textarea
                type="text" 
                name="about" 
                id="editor" 
                class="form-control {{ $errors->has("name") ? "form-control-error" : "" }}"
            >{{ old("about", $settings->about) }}</textarea>

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
                value="{{ old("mobile", $settings->mobile) }}" 
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
                value="{{ old("email", $settings->email) }}" 
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
                value="{{ old("gst", $settings->gst) }}" 
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
                value="{{ old("shipping_cost", $settings->shipping_cost) }}" 
                class="form-control {{ $errors->has("shipping_cost") ? "form-control-error" : "" }}"
            >

            @error("shipping_cost")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection