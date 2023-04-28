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
                            <th>Order No.</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th>Placed At</th>
                            <th>Total Amount</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    <span class="badge bg-success">{{ $order->status }}</span>
                                </td>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ $order->total_amount }}</td>
                                <td>{{ $order->total_items }}</td>
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