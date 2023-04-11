@extends("admin.base")

@section("content")
<form action="/admin/products/{{ $product_id }}/variations" method="post">
    @method("patch")
    @csrf
    <input type="number" id="samePrice">
    <button onclick="setSamePrice(event)" type="button">Set Same Price</button>

    <div class="container">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="fw-bold text-primary">Variations</span>
                <button class="btn btn-sm btn-primary" type="submit">Save</button>
            </div>
    
            <div class="card-body">


                    <table class="table table-bordered">
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
                                <td>
                                    @foreach ($variation->options as $option)

                                    <div>{{ $option->attribute }} - {{ $option->name }}</div>

                                    @endforeach
                                </td>

                                <td>
                                    <input class="form-control price" type="number" value="{{ $variation->price }}" name="variations[{{ $loop->index }}][price]">
                                </td>

                                <td>
                                    <input class="form-control" type="number" value="{{ $variation->stock }}" name="variations[{{ $loop->index }}][stock]">
                                </td>

                                <td>
                                    <input type="hidden" name="variations[{{ $loop->index }}][id]" value="{{ $variation->id }}">
                                    
                                    <input type="text" name="variations[{{ $loop->index }}][image_url]">

                                    <img src="{{ $variation->image_url }}" height="60px" width="60px">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
             
            </div>
        </div>
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