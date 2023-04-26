@extends("admin.base")

@section("content")
<form enctype="multipart/form-data" action="/admin/products/{{ $product->id }}" class="card-body" method="post">
    @csrf
    @method("patch")
    <div class="container my-4 px-3 mx-auto" style="max-width: 800px">
        <div class="card">
            <div class="card-header fw-bold text-primary">
                Edit Product</div>

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

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="hidden" name="image_url">
                    <div class="ig-item border rounded">
                      <img id="imgPicker" height="80px" width="80px" class="img-fluid" src="http://localhost:8000/uploads/photos/1/watches/w2.png">
                    </div>
                </div>

              
                <label for="Image" class="form-label">Gallery</label>

                <div class="d-flex gap-2">
                    <div class="ig-item border rounded">
                      <img id="igPicker" height="80px" width="80px" class="img-fluid" src="http://localhost:8000/uploads/photos/1/watches/w2.png">
                    </div>
                </div>

                {{-- <x-server-image name="image_url" :value="$product->image_url" style="height:80px;width:80px;object-fit:cover"/> --}}
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                
                @if ($product->has_variations)
                <a class="btn btn-outline-secondary" href="/admin/products/{{ $product->id }}/attributes" class="mx-3">Attributes</a>
                    
                <a class="btn btn-outline-secondary" href="/admin/products/{{ $product->id }}/variations" class="">Variations</a>
                @endif
            </div>
        </div>
    </div>
</form>
<script>
  $("#igPicker").click(function() {
    window.open("/laravel-filemanager?type=image&multiple=true", "FileManager", "width=900,height=600")
    window.SetUrl = items => {
      items.forEach(item => {
        $(this).parent().parent().prepend(`
          <div class="ig-item border rounded">
              <div class="ig-overlay">
                  <button type="button" class="fa fa-close ig-close"></button>
              </div>
              <input type="hidden" name="gallery[]" value="${item.url}">
              <img height="80px" width="80px" class="img-fluid" src="${item.url}">
          </div>
        `)
      })
    }
  })

  $("#imgPicker").click(function() {
    window.open("/laravel-filemanager?type=image&multiple=true", "FileManager", "width=900,height=600")
    window.SetUrl = items => {
      $(this).attr("src", items[0].url)
    }
  })
  $(".card-body").on("click", ".ig-close", function(event) {
    $(this).parent().parent().get(0).remove()
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