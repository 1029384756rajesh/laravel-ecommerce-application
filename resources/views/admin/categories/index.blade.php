@extends("admin.base")

@section("content")
<div class="container my-4 px-3">    
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <span class="card-header-title">Categories</span>
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
                                <td>
                                    @for ($i = 1; $i < $category["label"]; $i++) — @endfor
                                    {{ $category["name"] }}
                                </td>

                                <td>{{ date("d-m-Y", strtotime($category["created_at"]))}}</td>
                            
                                <td>
                                    <div class="flex gap-2 text-gray-600 items-center">
                                        <a href="/admin/categories/{{ $category["id"] }}" class="text-indigo-600 underline">Edit</a>
                                    |
                                        <form action="/admin/categories/{{ $category["id"] }}" method="post">
                                            @csrf @method("delete")
                                            <button type="submit" class="text-indigo-600 underline">Delete</button>
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