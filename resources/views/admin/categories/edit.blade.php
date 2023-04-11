@extends("admin.base")

@section("content")
<div class="container my-4 px-3">
    <div class="card">
        <div class="card-header fw-bold text-primary">Edit Category</div>

        <form enctype="multipart/form-data" action="/admin/categories/{{ $category->id }}" class="card-body" method="post">
            @csrf
            @method("patch")

            <x-form-control type="text" label="Name" id="name" name="name" :value="$category->name"/>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection