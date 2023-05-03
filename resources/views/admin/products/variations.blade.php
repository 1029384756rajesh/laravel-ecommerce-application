@extends("admin.base")

@section("content")
<form action="/admin/products/{{ $product->id }}/variations" method="post" class="card mx-auto max-w-4xl">
    @method("patch")
    @csrf
    
    <div class="card-header card-header-title">Variations</div>

    <div class="card-body">
        @foreach ($errors->all() as $error)
        <div>{{$error}}</div>
    @endforeach
        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Variation</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Image</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($variations as $variation)
                        <tr>
                            <td width="35%">
                                @foreach ($variation->values as $value)
                                    <div>{{ $value->value }} - {{ $value->attribute->name }}</div>
                                @endforeach
                            </td>

                            <td width="20%">
                                <input class="form-control" type="number" value="{{ $variation->price }}" name="variations[{{ $loop->index }}][price]">
                            </td>

                            <td width="20%">
                                <input class="form-control" type="number" value="{{ $variation->stock }}" name="variations[{{ $loop->index }}][stock]">
                            </td>

                            <td width="25%">
                                <input type="hidden" name="variations[{{ $loop->index }}][id]" value="{{ $variation->id }}">

                                <div data-fp="single" data-fp-input="#imageUrl" data-fp-preview="#imagePreview" class="relative group h-20 w-20 rounded border border-gray-300 cursor-pointer">
                                    <input type="hidden" id="imageUrl" value="{{ old("variations.{$loop->index}.image_url", $variation->image_url) }}" name="variations[{{ $loop->index }}][image_urls]">
                                    
                                    <div data-fp-reset class="group-hover:flex hidden absolute right-1 top-1 text-lg bg-black bg-opacity-60 rounded-full w-6 h-6 items-center justify-center text-white">
                                        <i class="fa fa-close text-2xl cursor-pointer"></i>
                                    </div>

                                    <img id="imagePreview" src='{{ ($image_url = old("variations.{$loop->index}.image_urls", $variation->image_url)) ? $image_url : "/assets/placeholder.png" }}' class="h-full w-full object-cover">
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer flex gap-2 justify-end">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
    <script>
        function setSamePrice(event) {
            if(document.querySelector("#samePrice").value == '') return
            
            const price = Number(document.querySelector("#samePrice").value)

            document.querySelectorAll(".price").forEach(element => {
                element.value = price
            });
        }
    </script>
@endsection