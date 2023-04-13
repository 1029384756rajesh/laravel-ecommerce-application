@extends('base')

@section('content')
<div class="container my-4 px-2">
    <div class="card">
        <div class="card-header fw-bold text-primary">My Orders</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="min-width: 1024px;">
                    <thead>
                        <tr>
                            <th>Order No.</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th>Placed At</th>
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
                            <td>{{ $order->updated_at }}</td>
                            <td>{{ $order->total_amount }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning">View</button>
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