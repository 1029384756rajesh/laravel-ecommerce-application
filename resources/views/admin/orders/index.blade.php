@extends("admin.base")

@section("head")
    <title>Orders</title>
@endsection

@section("content")
    <div class="card">
        <div class="card-header card-header-title">Orders</div>

        <div class="card-body">
            <div class="table-responsive">
                <div class="table min-w-[1024px]">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>status</th>
                                <th>Total Amount</th>
                                <th>Total Products</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                          @if (count($orders) == 0)
                              <tr>
                                <td colspan="7" class="text-center">No Orders Found</td>
                              </tr>
                          @endif
                          
                          @foreach ($orders as $order)
                              <tr>
                                  <td>{{ $order->id }}</td>
                                  <td>{{ $order->email }}</td>
                                  <td>{{ $order->status }}</td>
                                  <td>₹ {{ $order->total_amount }}</td>
                                  <td>{{ $order->total_products }}</td>
                                  <td>{{ $order->created }}</td>
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
</div>
@endsection