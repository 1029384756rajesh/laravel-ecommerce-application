@extends('admin.base')

@section('content')
<div class="container my-4 px-3">    

    <div class="card">

        <div class="card-header d-flex align-items-center justify-content-between">
            <span class="fw-bold text-primary">Categories</span>
            <a href="/admin/categories/create" class="btn btn-sm btn-primary">Add New</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="min-width: 1024px">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Last Updated</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($categories) == 0)

                        <tr>
                            <td colspan="4" class="text-center">No Category Found</td>
                        </tr>

                        @endif

                        @foreach ($categories as $category)

                        <tr>
                            <td>{{ $category->name }}</td>

                            <td>{{ date("d-m-Y", strtotime($category->created_at))}}</td>
                          
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="/admin/categories/{{ $category->id }}" class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form action="/admin/categories/{{ $category->id }}" method="post">
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