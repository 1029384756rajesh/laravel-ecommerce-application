@extends("base")

@section("content")
<div class="max-w-6xl mx-auto px-3 grid grid-cols-12 gap-6">
    <div class="col-span-4">
        <img src="{{ $product->image_url }}" class="w-full object-cover" id="mainImg">

        <div class="grid grid-cols-4 mt-3 gap-2">
            <img src="{{ $product->image_url }}" class="w-full object-cover cursor-pointer gallery-img">

            @foreach (explode("|", $product->gallery_urls) as $gallery_url)
                <img src="{{ $gallery_url }}" class="w-full object-cover cursor-pointer gallery-img">
            @endforeach
        </div>
    </div>

    <div class="col-span-8">
        <h3 class="font-bold text-xl">{{ $product->name }}</h3>

        <p class="mt-3 text-gray-600">{{ $product->short_description }}</p>
        
        <h4 id="price" class="text-indigo-600 mt-3 font-bold text-xl">{{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}</h4>

        @foreach ($product->attributes as $attribute)
            <div class="mt-3 max-w-[200px]">
                <label for="{{ $attribute->name }}" class="form-label">{{ $attribute->name }}</label>

                <select name="{{ $attribute->name }}" id="{{ $attribute->name }}" class="form-control">
                    <option></option>
                    
                    @foreach ($attribute->options as $option)
                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                    @endforeach
                </select>
            </div>                
        @endforeach

        <div class="flex gap-3 mt-4">
            <div class="flex">
                <input type="number" name="quantity" class="form-control max-w-[100px] rounded-r-none" value="1">
                <button id="cart" class="btn btn-primary rounded-l-none">Add to cart</button>
            </div>
            <button id="wishlist" class="btn btn-secondary">Add to wishlist</button>
        </div>

        <span class="text-danger d-none mt-3" id="stock"></span>

        <div>{{ $product->description }}</div>
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