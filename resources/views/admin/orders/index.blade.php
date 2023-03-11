@extends('admin.base')

@section('content')
<div class="container my-4 px-3">    
    <div class="card">
        <div class="card-header fw-bold text-primary">Orders</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" style="min-width: 1024px">
              <thead>
                <tr>
                  <th scope="col">Order ID</th>
                  <th scope="col">Total Products</th>
                  <th scope="col">Email</th>
                  <th scope="col">status</th>
                  <th scope="col">Total Amount</th>
                  <th scope="col">Last Updated</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                @if (count($orders) == 0)
                    <tr>
                      <td colspan="6" class="text-center">No Orders Found</td>
                    </tr>
                @endif
                
                @foreach ($orders as $order)
                <tr>
                  <td>{{ $order->id }}</td>
                  <td>{{ count($order->products) }}</td>
                  <td>{{ $order->user->email }}</td>
                  <td>
                    @if ($order->status->name == 'Delivered')
                        <div class="badge bg-success">{{ $order->status->name }}</div>
                    @endif
                    @if ($order->status->name == 'Placed')
                        <div class="badge bg-secondary">{{ $order->status->name }}</div>
                    @endif
                    @if ($order->status->name == 'Accepted')
                        <div class="badge bg-info">{{ $order->status->name }}</div>
                    @endif
                    @if ($order->status->name == 'Rejected')
                        <div class="badge bg-danger">{{ $order->status->name }}</div>
                    @endif
                    @if ($order->status->name == 'Shipped')
                        <div class="badge bg-warning">{{ $order->status->name }}</div>
                    @endif
                  </td>
                  <td>{{ $order->paymentInfo->total_amount }}</td>
                  <td>{{ date('d-m-Y', strtotime($order->updated_at))}}</td>
                  <td>
                     <div class="d-flex gap-1">
                      <a href="{{ route('admin.orders.show', ['order' => $order->id]) }}" class="btn btn-sm btn-warning">
                          <span class="material-icons">visibility</span>
                      </a>
 
                     </div>
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