@extends("admin.base")

@section("content")
<div class="card mx-auto max-w-lg">
    <div class="card-header card-header-title">Create New Category</div>

    <form enctype="multipart/form-data" action="/admin/categories" class="card-body" method="post">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Name</label>

            <input type="text" name="name" id="name" class="form-control {{ $errors->has("name") ? "form-control-error" : "" }}" value="{{ old("name") }}">

            @error("name")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="parentId" class="form-label">Parent Category</label>

            <select name="parent_id" class="form-control {{ $errors->has("name") ? "form-control-error" : "" }}" id="parentId">
                <option></option>
                @foreach ($categories as $category)
                    <option {{ old("parent_id") == $category["id"] ? "selected" : ""  }} value={{ $category["id"] }}> 
                        @for ($i = 1; $i < $category["label"]; $i++) — @endfor {{ $category["name"] }}
                    </option>
                @endforeach
            </select>

            @error("parent_id")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection