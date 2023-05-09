@extends("admin.base")

@section("head")
    <title>Create Product</title>
@endsection

@section("content")
<div class="card mx-auto max-w-3xl">
    <div class="card-header card-header-title">Create New Product</div>

    <form action="/admin/products/store" class="card-body" method="post">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Name</label>
            
            <input type="text" name="name" id="name" value="{{ old("name") }}" class="form-control {{ $errors->has("name") ? "form-control-error" : "" }}">
            
            @error("name")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="categoryId" class="form-label">Category</label>

            <select name="category_id" class="form-control {{ $errors->has("category_id") ? "form-control-error" : "" }}" id="categoryId">
                <option></option>

                @foreach ($categories as $category)
                    <option {{ old("category_id") == $category->id ? "selected" : "" }} value="{{ $category->id }}"> 
                        @for ($i=1; $i < $category->label; $i++) — @endfor {{ $category->name }}
                    </option>
                @endforeach
            </select>

            @error("category_id")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="shortDescription" class="form-label">Short Description</label>
            
            <input type="text" name="short_description" id="shortDescription" class="form-control {{ $errors->has("short_description") ? "form-control-error" : "" }}">
            
            @error("short_description")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label class="form-label" for="editor">Description</label>
            
            <textarea name="description" id="editor"></textarea>
            
            @error("description")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="price" class="form-label">Price</label>
            
            <input type="number" name="price" id="price" value="{{ old("price") }}" class="form-control {{ $errors->has("price") ? "form-control-error" : "" }}">
            
            @error("price")
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock" class="form-label">Stock</label>
            
            <input type="number" name="stock" id="stock" value="{{ old("stock") }}" class="form-control">
        </div>

        <div class="form-group form-check">
            <input type="hidden" name="has_variations" value="0">
            
            <input type="checkbox" name="has_variations" id="hasVariations" class="form-check-input" value="1">
            
            <label for="hasVariations" class="form-check-label">Has Variations</label>
        </div>

        <div class="form-group">
            <label class="form-label">Images</label>

            <div class="flex flex-wrap">
                <img src="/uploads/placeholder.png" data-fp="multiple" data-fp-container=".images" data-fp-name="images[]" class="mr-2 rounded border border-gray-300 object-cover h-20 w-20 cursor-pointer">
            
                <ul class="images flex flex-wrap gap-2">
                    @if (old("images"))
                        @foreach (old("images") as $image)
                            <li>
                                <input type="hidden" name="images[]" value="{{ $image }}">
                                <img src="{{ $image }}" class="h-20 w-20 border border-gray-300 object-cover mr-2 last:mr-0">
                            </li>   
                        @endforeach
                    @endif
                </ul>
            </div>
     
            @error("images")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

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