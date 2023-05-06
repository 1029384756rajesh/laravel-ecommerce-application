@extends("admin.base")

@section("content")
<div class="card">
    <div class="card-header flex items-center justify-between">
        <span class="card-header-title">Categories</span>
        <a href="/admin/categories/create" class="btn btn-sm btn-primary">Add New</a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <div class="table min-w-[1024px]">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
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
                                    @for ($i=1; $i<$category->label; $i++) — @endfor {{ $category->name }}
                                </td>
                                
                                <td>
                                    <div class="flex gap-2 items-center">
                                        <a href="/admin/categories/{{ $category->id }}/edit" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
    
                                        <form action="/admin/categories/{{ $category->id }}" method="post">
                                            @csrf
                                            @method("delete")
    
                                            <button class="btn btn-sm btn-danger">
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