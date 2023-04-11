@extends("admin.base")

@section("content")
<div class="container my-4 px-3">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span class="fw-bold text-primary">Setting</span>
            <a href="/admin/settings/edit" class="btn btn-sm btn-primary">Edit Settings</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="min-width: 600px">
                    <tr>
                        <td>About Us</td>
                        <td>{{ $setting->about }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $setting->email }}</td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>{{ $setting->mobile }}</td>
                    </tr>
                    <tr>
                        <td>Facebook URL</td>
                        <td>{{ $setting->facebook_url }}</td>
                    </tr>
                    <tr>
                        <td>Instagram URL</td>
                        <td>{{ $setting->instagram_url }}</td>

                    </tr>
                    <tr>
                        <td>Twitter URL</td>
                        <td>{{ $setting->twitter_url }}</td>
                    </tr>
                    <tr>
                        <td>GST</td>
                        <td>{{ $setting->gst }}%</td>
                    </tr>
                    <tr>
                        <td>Shipping Cost</td>
                        <td>{{ $setting->shipping_cost }}</td>
                    </tr>
                    <tr>
                        <td>Return Address</td>
                        <td>{{ $setting->return_address }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection