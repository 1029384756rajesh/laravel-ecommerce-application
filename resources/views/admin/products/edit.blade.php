@extends("admin.base")

@section("head")
    <title>Edit Product</title>
@endsection

@section("content")
<form action="/admin/products/{{ $product->id }}" method="post" class="card mx-auto max-w-3xl">
    @csrf
    @method("patch")

    <div class="card-header card-header-title">Edit New Product</div>

    <div class="card-body">
        <div class="form-group">
            <label for="name" class="form-label">Name</label>
            
            <input type="text" name="name" id="name" value="{{ old("name", $product->name) }}" class="form-control {{ $errors->has("name") ? "form-control-error" : "" }}">
            
            @error("name")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="categoryId" class="form-label">Category</label>

            <select name="category_id" class="form-control {{ $errors->has("category_id") ? "form-control-error" : "" }}" id="categoryId">
                <option></option>

                @foreach ($categories as $category)
                    <option {{ old("category_id", $product->category_id) == $category->id ? "selected" : "" }} value="{{ $category->id }}"> 
                        @for ($i=1; $i<$category->label; $i++) — @endfor {{ $category->name }}
                    </option>
                @endforeach
            </select>

            @error("category_id")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="shortDescription" class="form-label">Short Description</label>
            
            <input type="text" name="short_description" id="shortDescription" value="{{ old("short_description", $product->short_description) }}" class="form-control {{ $errors->has("short_description") ? "form-control-error" : "" }}">
            
            @error("short_description")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label class="form-label" for="editor">Description</label>
            
            <textarea name="description" id="editor">{{ $product->description }}</textarea>
            
            @error("description")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="price" class="form-label">Price</label>
            
            <input type="number" name="price" id="price" value="{{ old("price", $product->price) }}" class="form-control {{ $errors->has("price") ? "form-control-error" : "" }}">
            
            @error("price")
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock" class="form-label">Stock</label>
            
            <input type="number" name="stock" id="stock" value="{{ old("stock", $product->stock) }}" class="form-control">
        </div>

        <div class="form-group form-check">
            <input type="hidden" name="has_variations" value="0">
            
            <input type="checkbox" name="has_variations" id="hasVariations" class="form-check-input" value="1" {{ old("has_variations", $product->has_variations) ? "checked" : "" }}>
            
            <label for="hasVariations">Has Variations</label>
        </div>

        <div>
            <label class="form-label">Images</label>

            <div class="flex flex-wrap">
                <img src="/uploads/placeholder.png" data-fp="multiple" data-fp-container=".images" data-fp-name="images[]" class="mr-2 rounded border border-gray-300 object-cover h-20 w-20 cursor-pointer">
            
                <ul class="images flex flex-wrap gap-2">
                    @foreach (old("images", $product->images) as $image)
                        <li>
                            <input type="hidden" name="images[]" value="{{ $image }}">
                            <img src="{{ $image }}" class="h-20 w-20 border border-gray-300 object-cover mr-2 last:mr-0">
                        </li>   
                    @endforeach
                </ul>
            </div>

            @error("images")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="card-footer flex gap-1">
        <button type="submit" class="btn btn-primary">Save</button>

        @if ($product->has_variations)
            <a href="/admin/products/{{ $product->id }}/attributes" class="btn btn-outline-secondary">Attributes</a>
            <a href="/admin/products/{{ $product->id }}/variations" class="btn btn-outline-secondary">Variations</a>
        @endif
    </div>
</form>

<script>
    $(".images").sortable()

    $("input[name=has_variations]").change(function() {
        if($("input[name=has_variations]").is(":checked")) {
            $("input[name=price]").closest("div").hide()
            $("input[name=stock]").closest("div").hide()
        } else {
            $("input[name=price]").closest("div").show()
            $("input[name=stock]").closest("div").show()
        }
    })

    if($("input[name=has_variations]").is(":checked")) {
        $("input[name=price]").closest("div").hide()
        $("input[name=stock]").closest("div").hide()
    } else {
        $("input[name=price]").closest("div").show()
        $("input[name=stock]").closest("div").show()
    }
</script>
@endsection