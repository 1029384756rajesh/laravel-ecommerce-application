@extends("admin.base")

@section("head")
    <title>Edit Category</title>
@endsection

@section("content")
<div class="card mx-auto max-w-xl">
    <div class="card-header card-header-title">Edit Category</div>

    <form action="/admin/categories/{{ $category->id }}" class="card-body" method="post">
        @csrf 
        @method("patch")

        <div class="form-group">
            <label for="name" class="form-label">Name</label>

            <input type="text" name="name" id="name" value="{{ old("name", $category->name) }}" class="form-control {{ $errors->has("name") ? "form-control-error" : "" }}">
        
            @error("name")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="parentId" class="form-label">Parent Id</label>
            
            <select name="parent_id" id="parentId" class="form-control {{ $errors->has("parent_id") ? "form-control-error" : "" }}">
                <option></option>

                @foreach ($categories as $lcategory)
                    <option {{ $lcategory->id == old("parent_id", $category->parent_id) ? "selected" : ""}} value={{ $lcategory->id }}> 
                        @for ($i=1; $i<$lcategory->label; $i++) — @endfor {{ $lcategory->name }}
                    </option>
                @endforeach
            </select>

            @error("parent_id")
                <div class="invalid-feedback">{{ $message}}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection