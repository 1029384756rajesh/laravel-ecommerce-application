@extends("admin.base")

@section("content")
<form enctype="multipart/form-data" action="/admin/products/{{ $product->id }}" class="card-body" method="post">
    @csrf
    @method("patch")
    <div class="container my-4 px-3">
        <div class="card">
            {{-- <div class="card-header fw-bold text-primary">
                Edit Product</div> --}}

                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                          <a class="nav-link active" aria-current="true" href="#">General</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#">Description</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link">Image</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link">Attributes</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link">Variations</a>
                        </li>
                      </ul>
                </div>

            <div class="card-body">
                <x-form-control label="Name" type="text" id="name" name="name" :value="$product->name"/>

                {{-- <x-form-select label="Category" id="category_id" name="category_id" :value="$product->category_id" :options="$categories"/> --}}

                  <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" class="form-control form-select">
                        <option></option>
                        @foreach ($categories as $c)
    
                        <option {{ $product->category_id == $c["id"] ? "selected" : ""}}  value={{ $c["id"] }}> 
                            @if ($c["label"] > 1)
                                @for ($i = 1; $i < $c["label"]; $i++)
                                —
                                @endfor
                            @endif
                         
                            {{ $c["name"]}}</option>
                        @endforeach
                      </select>
                </div>
                <x-form-control label="Short Description" type="text" id="short_description" name="short_description" :value="$product->short_description"/>
                
                <x-form-control label="Description" type="textarea" id="description" name="description" :value="$product->description"/>

                <x-form-control label="Stock" type="number" id="stock" name="stock" :value="$product->stock"/>

                <x-form-control label="Price" type="number" id="price" name="price" :value="$product->price"/>

                {{-- <x-form-control label="Image" type="text" id="image_url" name="image_url" :value="$product->image_url"/> --}}

                <x-form-check id="is_featured" name="is_featured" :value="$product->is_featured" label="Featured"/>

                <x-form-check id="has_variations" name="has_variations" :value="$product->has_variations" label="Has Variations"/>

                <x-form-check id="is_active" name="is_active" value="1" label="Active"/>

                <label for="Image" class="form-label">Image</label>
                <x-server-image name="image_url" :value="$product->image_url" style="height:80px;width:80px;object-fit:cover"/>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                
                @if ($product->has_variations)
                <a href="/admin/products/{{ $product->id }}/attributes" class="mx-3">Attributes</a>
                    
                <a href="/admin/products/{{ $product->id }}/variations" class="">Variations</a>
                @endif
            </div>
        </div>
    </div>
</form>
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

    $("input[name=has_variations]").change(setPriceStock)
    
    setPriceStock()

</script>

@endsection