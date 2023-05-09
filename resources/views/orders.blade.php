@extends("base")

@section("head")
    <title>Orders</title>
@endsection

@section("content")
<div class="card max-w-5xl mx-auto">
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
                                @switch($order->status)
                                    @case("Delivered")
                                        <span class="badge badge-success">{{ $order->status }}</span>
                                        @break

                                    @case("Shipped")
                                        <span class="badge badge-warning">{{ $order->status }}</span>
                                        @break

                                    @case("Canceled")
                                        <span class="badge badge-danger">{{ $order->status }}</span>
                                        @break

                                    @default
                                        <span class="badge badge-secondary">{{ $order->status }}</span>
                                @endswitch
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
@endsection