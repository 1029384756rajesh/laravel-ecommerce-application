@extends('admin.base')

@section('content')
<div class="container my-4 px-3">
    <div class="card">
        <div class="card-header fw-bold text-primary">Edit Setting</div>

        <form action="/admin/settings" class="card-body" method="post">
            @csrf
            @method("patch")

            <x-form-control type="text" label="About" id="about" name="about" :value="$setting->about"/>

            <x-form-control type="text" label="Mobile" id="mobile" name="mobile" :value="$setting->mobile"/>

            <x-form-control type="text" label="Email" id="email" name="email" :value="$setting->email"/>

            <x-form-control type="text" label="Facebook Url" id="facebook_url" name="facebook_url" :value="$setting->facebook_url"/>

            <x-form-control type="text" label="Instagram Url" id="instagram_url" name="instagram_url" :value="$setting->instagram_url"/>

            <x-form-control type="text" label="Twitter Url" id="twitter_url" name="twitter_url" :value="$setting->twitter_url"/>

            <x-form-control type="text" label="Gst" id="gst" name="gst" :value="$setting->gst"/>

            <x-form-control type="text" label="Shipping Cost" id="shipping_cost" name="shipping_cost" :value="$setting->shipping_cost"/>

            <x-form-control type="text" label="Return Address" id="return_address" name="return_address" :value="$setting->return_address"/>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection