@extends("admin.base")

@section("content")
<div class="">
    <div class="card mx-auto max-w-lg">
        <div class="card-header card-header-title">Create New Category</div>

        <form enctype="multipart/form-data" action="/admin/categories" class="card-body" method="post">
            @csrf

            <x-form-control type="text" label="Name" id="name" name="name"/>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Parent Category</label>
                <select name="parent_id" class="form-control form-select" id="parent_id">
                    <option></option>
                    @foreach ($categories as $category)
                        <option {{ old("parent_id") == $category["id"] ? "selected" : ""  }} value={{ $category["id"] }}> 
                            @for ($i = 1; $i < $category["label"]; $i++) — @endfor {{ $category["name"] }}
                        </option>
                    @endforeach
              </select>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection