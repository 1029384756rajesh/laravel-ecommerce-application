@extends("admin.base")

@section("head")
<title>Edit Category</title>
@endsection

@section("content")
<div class="container my-4 px-3">
    <div class="card mx-auto" style="max-width: 500px">
        <div class="card-header fw-bold text-primary">Edit Category</div>

        <form enctype="multipart/form-data" action="/admin/categories/{{ $category->id }}" class="card-body" method="post">
            @csrf @method("patch")

            <x-form-control type="text" label="Name" id="name" name="name" :value="$category->name"/>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Parent Id</label>
                <select name="parent_id" class="form-control form-select {{ $errors->has("parent_id") ? "is-invalid" : "" }}">
                    <option></option>
                    @foreach ($categories as $lcategory)
                        <option {{ $lcategory["id"] == old("parent_id", $category->parent_id) ? "selected" : ""}} value={{ $lcategory["id"] }}> 
                            @for ($i = 1; $i < $lcategory["label"]; $i++) — @endfor {{ $lcategory["name"]}}
                        </option>
                    @endforeach
                </select>
                @error("parent_id")
                    <span class="invalid-feedback">{{ $message}}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection