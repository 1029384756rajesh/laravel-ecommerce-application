@extends("admin.base")

@section("head")
    <title>Settings</title>
@endsection

@section("content")
<div class="container my-4 px-3">
    <div class="card mx-auto max-w-3xl">
        <div class="card-header flex items-center justify-between">
            <span class="card-header-title">Setting</span>
            <a href="/admin/settings/edit" class="btn btn-sm btn-primary">Edit Settings</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <div class="table min-w-[700px]">
                    <table>
                        <tr>
                            <td>About</td>
                            <td>{{ $settings->about }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $settings->email }}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{ $settings->mobile }}</td>
                        </tr>
                        <tr>
                            <td>GST</td>
                            <td>{{ $settings->gst }}%</td>
                        </tr>
                        <tr>
                            <td>Shipping Cost</td>
                            <td>{{ $settings->shipping_cost }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection