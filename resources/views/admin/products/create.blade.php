@extends("admin.base")

@section("head")
<title>Create Product</title>
@endsection

@section("content")
<div class="container my-4 px-3">
    <div class="card mx-auto" style="max-width:700px">
        <div class="card-header fw-bold text-primary">Create New Product</div>

        <form  enctype="multipart/form-data" action="/admin/products/store" class="card-body" method="post">
            @csrf

            <x-form-control label="Name" type="text" id="name" name="name"/>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>

                <select name="category_id" class="form-control form-select">
                    <option></option>
                    @foreach ($categories as $category)
                        <option {{ old("category_id") == $category["id"] ? "selected" : "" }}  value={{ old("category_id", $category["id"]) }}> 
                            @for ($i = 1; $i < $category["label"]; $i++) — @endfor {{ $category["name"]}}
                        </option>
                    @endforeach
                </select>

                @error("category_id")
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <x-form-control label="Short Description" type="text" id="short_description" name="short_description"/>
            
            <div class="mb-3">
                <label class="form-label">Description</label>
                <div class="ckeditor"></div>
            </div>

            <x-form-control label="Stock" type="number" id="stock" name="stock"/>

            <x-form-control label="Price" type="number" id="price" name="price"/>

            <x-form-check id="is_featured" name="is_featured" value="1" label="Featured"/>

            <x-form-check id="has_variations" name="has_variations" label="Has Variations"/>

            <x-server-image name="image_url" label="Image" />

            <div class="mb-3">
                <label class="form-label">Image</label>

                <div data-fp="single" class="fp">
                    <div class="fp-data">
                        <input type="hidden" name="image_url">
                        <div class="fp-overlay">
                            <i class="fa fa-close fp-remove"></i>
                        </div>
                        <img class="fp-image" height="90px" width="90px">
                    </div>
                    <img src="/assets/placeholder.png" class="fp-preview">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Gallery</label>

                <div class="file-picker">
                    <div class="file-picker-item">
                        <div class="file-picker-overlay">
                            <i class="fa fa-close file-picker-close"></i>
                        </div>
                        <input type="hidden" name="image_url">
                        <img src="http://localhost:8000/uploads/photos/1/female/f5.png" class="file-picker-preview">
                    </div>

                    <img src="/assets/placeholder.png" class="file-picker-multiple">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

<script>
    $(".lfm-multiple").click(function() {
        window.open("/laravel-filemanager?type=image&multiple=true", "FileManager", "width=900,height=600")

        window.SetUrl = items => {
            items.forEach(item => {
                $(this).parent().prepend(`
                    <div class="lfm border rounded">
                        <div class="lfm-overlay">
                            <i class="fa fa-close lfm-overlay-icon"></i>
                        </div>
                        <input type="hidden" value="${item.url}" name="gallery[]"/>
                        <img src="${item.url}" class="lfm-preview">
                    </div>
                `)
            })
        }
    })

    $(".card-body").on("click", ".lfm-overlay-icon", function() {
        $(this).closest(".lfm").get(0).remove()
    })

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

    $("input[name=has_variations]").change(setPriceStock)
    
    setPriceStock()
</script>

@endsection