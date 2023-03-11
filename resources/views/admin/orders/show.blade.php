@extends('admin.base')

@section('content')
<div class="container my-4 px-3">    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Details</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body fw-bold text-primary">Products</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->products as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="/uploads/{{ $product->image_url }}" style="height: 100px; width: 100px; object-fit: cover;" alt="">
                                            <span>{{ $product->name }}</span>
                                        </div>
                                    </td>
                                    <td>5</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
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
            </div>
            <div class="card mt-3">
                <div class="card-header fw-bold text-primary">Shipping Address</div>
                <div class="card-body">
                    <p>Name - Rajesh Rout</p>
                    <p>Mobile - 7684948575</p>
                    <p class="mb-0">Address - J.P Nagar, 3rd cross, Near Axis Bank, Banglore, 455001</p>
                </div>
            </div>
            <form class="card mt-3" action="{{ route('admin.orders.update', ['order' => $order->id]) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="card-header fw-bold text-primary">Status</div>

                <div class="card-body">
                    <label for="status_id" class="form-label">Status</label>
                    <select name="status_id" id="status_id" class="form-select form-control">
                        @foreach ($statuses as $status)
                            <option {{ $order->status->id == $status->id ? 'selected' : '' }} value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-sm btn-warning">Update</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endsection