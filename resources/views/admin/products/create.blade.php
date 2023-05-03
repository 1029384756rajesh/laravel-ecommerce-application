@extends("admin.base")

@section("head")
<title>Create Product</title>
@endsection

@section("content")
<div class="card mx-auto max-w-3xl">
    <div class="card-header card-header-title">Create New Product</div>

    <form enctype="multipart/form-data" action="/admin/products/store" class="card-body" method="post">
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
                    <option {{ old("category_id") == $category["id"] ? "selected" : "" }} value="{{ $category["id"] }}"> 
                        @for ($i=1; $i < $category["label"]; $i++) — @endfor {{ $category["name"]}}
                    </option>
                @endforeach
            </select>

            @error("category_id")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="shortDescription" class="form-label">Short Description</label>
            
            <input 
                type="text" 
                name="short_description" 
                id="shortDescription" 
                class="form-control {{ $errors->has("short_description") ? "form-control-error" : "" }}"
            >
            
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
            
            <input 
                type="number" 
                name="price" 
                id="price" 
                value="{{ old("price") }}" 
                class="form-control {{ $errors->has("price") ? "form-control-error" : "" }}"
            >
            
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
            <label class="form-label">Gallery</label>

            <div class="flex flex-wrap gap-2">
                <ul id="gallery" class="flex flex-wrap gap-2">
                    @foreach (old("gallery_urls") ?? [] as $gallery_url)
                        <li class="relative group h-20 w-20 rounded border border-gray-300 overflow-hidden">
                            <div data-fp-remove class="group-hover:flex hidden absolute inset-0 bg-black bg-opacity-50 items-center justify-center text-white">
                                <i class="fa fa-close text-2xl cursor-pointer"></i>
                            </div>

                            <input type="hidden" name="images[]" value="{{ $gallery_url }}">

                            <img src="{{ $gallery_url }}" class="w-full h-full object-cover">
                        </li>   
                    @endforeach
                </ul>
                
                <img src="/assets/placeholder.png" data-fp="multiple" data-fp-container="#gallery" data-fp-name="images[]" class="rounded border border-gray-300 object-cover h-20 w-20 cursor-pointer">
            </div>

            @error("gallery_urls")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script>

    function setPriceStock() 
    {
        if($("input[name=has_variations]").is(":checked")) {
            $("input[name=price]").closest("div").hide()
            $("input[name=stock]").closest("div").hide()
        } else {
            $("input[name=price]").closest("div").show()
            $("input[name=stock]").closest("div").show()
        }
    }

    $("#gallery").sortable()
    $("#demo").sortable()

    $("input[name=has_variations]").change(setPriceStock)
    
    setPriceStock()
</script>
@endsection