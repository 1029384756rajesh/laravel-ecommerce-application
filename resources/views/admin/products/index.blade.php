@extends('admin.base')

@section('content')
<div class="container my-4 px-3">    
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <span class="fw-bold text-primary">Products</span>
            <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">Add New</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" style="min-width: 1024px">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Price</th>
                  <th scope="col">Description</th>
                  <th scope="col">Featured</th>
                  <th scope="col">Active</th>
                  <th scope="col">Stock</th>
                  <th scope="col">Image</th>
                  <th scope="col">Last Updated</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                @if (count($products) == 0)
                    <tr>
                      <td colspan="9" class="text-center">No Product Found</td>
                    </tr>
                @endif
                @foreach ($products as $product)
                <tr>
                  <td>{{ $product->name }}</td>
                  <td>{{ $product->price }}</td>
                  <td>{{ $product->short_description }}</td>
                  <td>
                    @if ($product->is_featured)
                        <span class="material-icons text-success">check_circle</span>
                    @else
                      <span class="material-icons text-danger">cancel</span>
                    @endif
                  </td>
                  <td>
                    @if ($product->is_active)
                        <span class="material-icons text-success">check_circle</span>
                    @else
                      <span class="material-icons text-danger">cancel</span>
                    @endif
                  </td>
                  <td>{{ $product->stock }}</td>
                  <td>
                      <img src="/uploads/{{ $product->image_url }}" class="img-fluid" width="80">
                  </td>
                  <td>{{ date('d-m-Y', strtotime($product->created_at))}}</td>
                  <td>
                     <div class="d-flex gap-1">
                      <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}" class="btn btn-sm btn-warning">
                          <span class="material-icons">edit</span>
                      </a>
                      <form action="{{ route('admin.products.destroy', ['product' => $product->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                          <button class="btn btn-sm btn-danger">
                              <span class="material-icons p-0 m-0">delete</span>
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
        <div class="card-footer">
          {{ $products->links() }}
        </div>
    </div>
</div>
@endsection