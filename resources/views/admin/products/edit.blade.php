@extends("admin.base")

@section("content")
<div class="container my-4 px-3">

    <div class="card">

        <div class="card-header fw-bold text-primary">Edit Product</div>

        <form enctype="multipart/form-data" action="/admin/products/{{ $product->id }}" class="card-body" method="post">
            @csrf
            @method("patch")

            <x-form-control label="Name" type="text" id="name" name="name" :value="$product->name"/>

            <x-form-select label="Category" id="category_id" name="category_id" :value="$product->category_id" :options="$categories"/>

            <x-form-control label="Short Description" type="text" id="short_description" name="short_description" :value="$product->short_description"/>
            
            <x-form-control label="Description" type="textarea" id="description" name="description" :value="$product->description"/>

            <x-form-control label="Stock" type="number" id="stock" name="stock" :value="$product->stock"/>

            <x-form-control label="Price" type="number" id="price" name="price" :value="$product->price"/>

            <x-form-control label="Image" type="text" id="image_url" name="image_url" :value="$product->image_url"/>

            <x-form-check id="is_featured" name="is_featured" value="1" label="Featured"/>

            <x-form-check id="has_variations" name="has_variations" :value="$product->has_variations" label="Has Variations"/>

            <x-form-check id="is_active" name="is_active" value="1" label="Active"/>

            {{-- <div id="editor">{{ $product->description }}</div>
            <script>
                ClassicEditor
                        .create( document.querySelector( '#editor' ) )
                        .catch( error => {
                            console.error( error );
                        } );
            </script> --}}

            <button type="submit" class="btn btn-warning">Update</button>
        </form>
    </div>
</div>

<script>

    // $("form").submit(function(event) {
    //     event.preventDefault()
    //     console.log($("#editor").html());
    // })

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