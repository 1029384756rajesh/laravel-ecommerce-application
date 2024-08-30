@extends("admin.base")

@section("head")
    <title>{{ isset($category) ? 'Edit Category' : 'Create Category'}}</title>
@endsection

@section("content")
<div class="card mx-auto max-w-lg">
    <div class="card-header card-header-title">{{ isset($category) ? 'Edit Category' : 'Create Category'}}</div>

    <form action="{{ isset($category) ? '/admin/categories/'.$category->id : '/admin/categories'}}" class="card-body" method="post">
        @csrf
        @method(isset($category) ? "PATCH" : "POST")

        <div class="form-group">
            <label for="name" class="form-label">Name</label>

            <input type="text" name="name" id="name" class="form-control {{ $errors->has("name") ? "form-control-error" : "" }}" value="{{ old("name", $category->name ?? '') }}">

            @error("name")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="parentId" class="form-label">Parent Category</label>

            <select name="parent_id" class="form-control {{ $errors->has("parent_id") ? "form-control-error" : null }}" id="parentId">
                <option value="">————</option>
                @foreach ($categories as $loopCategory)
                    <option 
                        {{ old("parent_id", $category->parent_id ?? null) == $loopCategory->id ? "selected" : null  }} value={{         $loopCategory->id }}
                    > 
                        @for ($i = 0; $i < $loopCategory->label; $i++) — @endfor {{ $loopCategory->name }}
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