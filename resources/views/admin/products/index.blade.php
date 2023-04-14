@extends('admin.base')

@section('content')
<div class="container">    

    <div class="card">

        <div class="card-header d-flex align-items-center justify-content-between">
            <span class="fw-bold text-primary">Products</span>
            <a href="/admin/products/create" class="btn btn-sm btn-primary">Add New</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="min-width: 1024px">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Featured</th>
                            <th scope="col">Variations</th>
                            <th scope="col">Image</th>
                            <th scope="col">Last Updated</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($products) == 0)

                        <tr>
                            <td colspan="4" class="text-center">No Category Found</td>
                        </tr>

                        @endif

                        @foreach ($products as $product)

                        <tr>
                            <td>{{ $product->name }}</td>

                            <td>{{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}</td>

                            <td>
                                @if ($product->is_featured) <i class="fa fa-check-circle text-success"></i> @else <i class="fa fa-times-circle text-danger"></i> @endif
                            </td>

                            <td>
                                @if ($product->has_variations) <i class="fa fa-check-circle text-success"></i> @else <i class="fa fa-times-circle text-danger"></i> @endif
                            </td>

                            <td>
                                <img src="{{ $product->image_url }}" height="60px" width="60px" class="img-fluid">
                            </td>

                            <td>{{ date("d-m-Y", strtotime($product->updated_at))}}</td>
                          
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="/admin/products/{{ $product->id }}" class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form action="/admin/products/{{ $product->id }}" method="post">
                                      @csrf
                                      @method("delete")

                                      <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
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