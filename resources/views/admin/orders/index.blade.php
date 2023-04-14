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
                  <th scope="col">ID</th>
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
                  <td>{{ $order->user->email }}</td>
                  <td>{{ $order->status }}</td>
                  <td>₹ {{ $order->paymentDetails->total_amount }}</td>
                  <td>{{ date('d-m-Y', strtotime($order->updated_at))}}</td>
                  <td>
                     <div class="d-flex gap-1">
                      <a href="/admin/orders/{{ $order->id }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-light fa-eye"></i>
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