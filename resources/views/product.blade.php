@extends('base')

@section('content')
<div class="container my-4 px-3">
    <div class="row">
        <div class="col-12 col-md-4">

            <img src="{{ $product->image_url }}" style="width: 100%" class="img-fluid" id="mainImg">

            <div class="row g-2 mt-2">
                <div class="col-3">
                    <img src="{{ $product->image_url }}" style="width: 100%" class="gallery-imgs img-fluid">
                </div>

                {{-- @foreach ($product->images as $image)
                <div class="col-3">
                    <img src="{{ $image->image_url }}" style="width: 100%" class="gallery-imgs img-fluid">
                </div>
                @endforeach --}}
            </div>
        </div>

        <div class="col-12 col-md-8">
            <h3 class="fw-bold mt-4 mt-md-0">{{ $product->name }}</h3>

            <p class="text-muted">{{ $product->short_description }}</p>

            {{-- <div class="d-flex gap-1">
                <x-rating/>
            </div> --}}

            {{-- <h4 class="fw-bold text-primary mt-2">{{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}</h4> --}}
            <h4 id="price" class="fw-bold text-primary mt-3">{{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}</h4>

            @foreach ($product->attributes as $attribute)
            <div class="mt-3" style="width:200px">
                <label for="" class="form-label fw-bold">{{ $attribute->name }}</label>
                <select name="option_id" id="" class="form-control form-select">
                    <option></option>
                    @foreach ($attribute->options as $option)
                    <option value="{{ $option->id }}">{{ $option->name }}</option>
                    @endforeach
                </select>
            </div>                
            @endforeach

            <div class="mt-3" style="width:200px">
                <label for="" class="form-label fw-bold">Quantity</label>
                <input type="number" name="quantity" class="form-control" value="1">
            </div>

            <div class="d-flex gap-2 mt-3">
                <button id="cart" class="btn btn-primary d-flex align-items-center gap-2">
                    <span class="material-icons" style="font-size: 20px;">shopping_cart</span> Add to cart
                </button>

                <button id="wishlist" class="btn btn-danger d-flex align-items-center gap-2" data-product_id="{{ $product->id }}">
                    <span class="material-icons" style="font-size: 20px;">favorite</span> Wishlist
                </button>
            </div>

            <span class="text-danger d-none mt-3" id="stock"></span>

            <h4 class="fw-bold text-info h6 mt-3">Description</h4>

            <p class="text-muted">{{ $product->description ? $product->description : "Not Available" }}</p>

        </div>
    </div>
</div>

<script>
    const product = @json($product)

    function checkTwoArraySame(arr1, arr2) 
    {
        if(arr1.length !== arr2.length) return false

        let counter = 0

        arr1.forEach(element => arr2.forEach(element2 => element == element2 && counter++))   
        
        return arr1.length === counter
    }

    $("select").change(function() {
        const option_ids = []

        $("select[name=option_id]").each(function() {
            option_ids.push($(this).val());
        })

        product.variations.forEach(variation => {
            if(!checkTwoArraySame(option_ids, variation.options)) return

            $("#price").html(`₹ ${variation.price}`)

            if(variation.image_url)
            {
                $("#mainImg").attr("src", variation.image_url)
            }

            if(variation.stock === 0)
            {
                $("#stock").html("This product is currently out of stock")
                $("#stock").removeClass("d-none")
                $("#stock").addClass("d-inline-block")
                delete product.variation_id
            }
            else 
            {
                $("#stock").removeClass("d-inline-block")
                $("#stock").addClass("d-none")
                product.variation_id = variation.id
            }
        })
    })

    $("button#cart").click(function() {
        if(product.has_variations && !product.variation_id) return

        $(this).attr("disabled", true)

        fetch(`/cart/${product.id}`, {
            method: "post",
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                quantity: $("input[name=quantity]").val(),
                variation_id: product.variation_id
            })
        })
        .then(async (response) => {
            response.status === 200 ? alert((await response.json()).success) : alert((await response.json()).error)
        })
        .catch(() => {
            alert("Sorry, An unknown error occured")
        })
        .finally(() => {
            $(this).attr("disabled", false)
        })
    })

</script>

@endsection