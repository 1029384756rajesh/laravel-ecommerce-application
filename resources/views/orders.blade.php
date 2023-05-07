@extends('base')

@section('content')
<div class="max-w-5xl mx-auto my-3">
    <div class="card">
        <div class="card-header card-header-title">My Orders</div>
        <div class="card-body">
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Status</th>
                            <th>Placed At</th>
                            <th>Total Amount</th>
                            <th>Total Products</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    <span class="badge {{ $order->status == "Delivered" ? "badge-success" : "badge-secondary"  }}">{{ $order->status }}</span>
                                </td>
                                <td>{{ $order->created }}</td>
                                <td>₹ {{ $order->total_amount }}</td>
                                <td>{{ $order->total_products }}</td>
                                <td>
                                    <a href="/orders/{{ $order->id }}" class="btn btn-outline-secondary btn-sm">View</a>
                                </td>
                            </tr>                            
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection