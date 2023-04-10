@extends('admin.base')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <input type="number" id="samePrice">
    <button onclick="setSamePrice(event)">Set Same Price</button>
    <form action="/api/products/20/variations" method="POST">
        @method('PATCH')
        @csrf
        <button class="btn btn-primary" type="submit">Submit</button>
        <table class="table">
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
                            @foreach ($variation['options'] as $option)
                                <div>{{ $option['attribute'] }} - {{ $option['name'] }}</div>
                            @endforeach
                        </td>
                        <td>
                            <input type="number" value="{{ $variation['price'] }}" class="price" name="variations[{{ $loop->index }}][price]">
                        </td>
                        <td>
                            <input type="number" value="{{ $variation['stock'] }}" name="variations[{{ $loop->index }}][stock]">
                        </td>
                        <td>
                            <input type="hidden" name="variations[{{ $loop->index }}][id]" value="{{ $variation['id'] }}">
                            <input type="text" name="variations[{{ $loop->index }}][image_url]">
                            <img src="{{ $variation['image_url'] }}" height="60px" width="60px">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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