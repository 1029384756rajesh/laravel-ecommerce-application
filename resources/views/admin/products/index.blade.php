@extends("admin.base")

@section("head")
    <title>Products</title>
@endsection

@section("content")
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <span class="card-header-title">Products</span>
            <a href="/admin/products/create" class="btn btn-sm btn-primary">Add New</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <div class="table min-w-[1024px]">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Variations</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($products) == 0)
                                <tr>
                                    <td colspan="5" class="text-center">No Products Found</td>
                                </tr>
                            @endif

                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>

                                    <td>
                                        @if ($product->is_completed)
                                            {{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}
                                        @else
                                            <span>Draft</span>
                                        @endif
                                    </td>

                                    <td>{{ $product->category }}</td>

                                    <td>
                                        @if ($product->has_variations) 
                                            <i class="fa fa-check-circle text-green-600"></i> 
                                        @else 
                                            <i class="fa fa-times-circle text-red-600"></i> 
                                        @endif
                                    </td>

                                    <td>
                                        <img src="/uploads/{{ $product->image }}" class="w-20 h-20 object-cover rounded-md">
                                    </td>
                                
                                    <td>
                                        <div class="flex gap-1">
                                            <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <form action="/admin/products/{{ $product->id }}" method="post">
                                                @csrf 
                                                @method("delete")

                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
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