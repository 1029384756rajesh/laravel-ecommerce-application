@extends("admin.base")

@section("content")
<div class="container my-4 px-3">

    <div class="card">
        <div class="card-header fw-bold text-primary">Create New Category</div>

        <form enctype="multipart/form-data" action="/admin/categories" class="card-body" method="post">
            @csrf

            <x-form-control type="text" label="Name" id="name" name="name"/>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
    
</div>
@endsection