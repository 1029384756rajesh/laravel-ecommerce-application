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
                        <tr>
                            <td>2303</td>
                            <td>
                                <span class="badge bg-success">Delivered</span>
                            </td>
                            <td>23-02-2022 10:15 PM</td>
                            <td>23-02-2022 10:15 PM</td>
                            <td>
                                <button class="btn btn-sm btn-warning">View</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2303</td>
                            <td>
                                <span class="badge bg-secondary">Shipped</span>
                            </td>
                            <td>23-02-2022 10:15 PM</td>
                            <td>23-02-2022 10:15 PM</td>
                            <td>
                                <button class="btn btn-sm btn-warning">View</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection