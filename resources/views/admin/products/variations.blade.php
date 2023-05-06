@extends("admin.base")

@section("content")
<form action="/admin/products/{{ $product->id }}/variations" method="post" class="card mx-auto max-w-7xl">
    @method("patch")
    @csrf
    
    <div class="card-header card-header-title">Variations</div>

    <div class="card-body">
        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th width="25%">Variation</th>
                        <th width="20%">Price</th>
                        <th width="20%">Stock</th>
                        <th width="35%">Image</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($variations as $variation)
                        <tr>
                            <td>
                                <input type="hidden" value="{{ $variation->id }}" name="id">
                                @foreach ($variation->attributes as $attribute)
                                    <div>{{ $attribute->name }} - {{ $attribute->option}}</div>
                                @endforeach
                            </td>

                            <td>
                                <input class="form-control" type="number" value="{{ $variation->price }}" name="price">
                            </td>

                            <td width="20%">
                                <input class="form-control" type="number" value="{{ $variation->stock }}" name="stock">
                            </td>

                            <td width="25%">
                                <div class="flex flex-wrap gap-2">
                                    <img src="/uploads/images/placeholder.png" data-fp="multiple" data-fp-container=".sortable" data-fp-name="image" class="rounded border border-gray-300 object-cover h-20 w-20 cursor-pointer">
                                
                                    <ul class="sortable flex flex-wrap gap-2">
                                        @foreach ($variation->images as $image)
                                            <li>
                                                <input type="hidden" name="image" value="{{ $image }}">
                                                <img src="{{ $image }}" class="h-20 w-20 border border-gray-300 object-cover">
                                            </li>   
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer flex gap-2 justify-end">
        <button type="button" class="btn-save btn btn-primary">Save</button>
    </div>
</form>

<script>
    $(".btn-save").click(async function() {
        const variations = []

        $("tbody tr").each(function() {
            const variation = {
                id: $(this).find("input[name=id]").val(),
                price: $(this).find("input[name=price]").val(),
                stock: $(this).find("input[name=stock]").val(),
                images: []
            }

            $(this).find("input[name=image]").each(function() {
                variation.images.push($(this).val())
            })

            variations.push(variation)
        })

        const response = await fetch("/admin/products/{{ $product->id }}/variations?_method=patch", {
            method: "post",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({variations})
        }) 

        console.log(await response.text());

        $(this).attr("disabled", false)
    })
</script>
@endsection