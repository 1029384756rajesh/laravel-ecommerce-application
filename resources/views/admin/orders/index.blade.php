@extends("admin.base")

@section("head")
<title>Orders</title>
@endsection

@section("content")
    <div class="card">
        <div class="card-header card-header-title">Orders</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered min-w-[1024px]">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>status</th>
                            <th>Total Amount</th>
                            <th>Last Updated</th>
                            <th></th>
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
                              <td>{{ date("d-m-Y", strtotime($order->updated_at))}}</td>
                              <td>
                                  <a href="/admin/orders/{{ $order->id }}" class="btn btn-sm btn-primary">View</a>
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