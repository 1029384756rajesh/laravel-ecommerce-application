@extends("base")

@section("head")
    <title>Product</title>
@endsection

@section("content")
<div class="max-w-6xl mx-auto grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-4">
        <img src="/uploads/{{ $product->images[0] }}" class="main-img w-full object-cover">

        <div class="grid grid-cols-4 mt-3 gap-2">
            @foreach ($product->images as $image)
                <img src="/uploads/{{ $image }}" class="gallery-img w-full object-cover cursor-pointer">
            @endforeach
        </div>
    </div>

    <div class="col-span-12 lg:col-span-8">
        <h3 class="font-bold text-xl">{{ $product->name }}</h3>

        <p class="mt-3 text-gray-600">{{ $product->short_description }}</p>
        
        <h4 class="text-indigo-600 mt-3 font-bold text-xl">{{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}</h4>

        @foreach ($product->attributes as $attribute)
            <div class="mt-4 max-w-[200px]">
                <label for="{{ $attribute->name }}" class="form-label">{{ $attribute->name }}</label>

                <select name="{{ $attribute->name }}" id="{{ $attribute->name }}" class="form-control">
                    <option></option>
                    
                    @foreach ($attribute->options as $option)
                        <option {{ in_array($option->id, $product->options) ? "selected" : "" }} value="{{ $option->id }}">{{ $option->name }}</option>
                    @endforeach
                </select>
            </div>                
        @endforeach

        <div class="flex mt-4">
            <input type="number" name="quantity" class="form-control max-w-[100px] rounded-r-none border-r-0" value="1" min="1">
            <button class="btn-cart btn btn-primary rounded-l-none">Add to cart</button>
        </div>

        <div class="mt-4 text-gray-800">{!! $product->description !!}</div>
    </div>
</div>

<script>
    const product = @json($product)

    function isArrayEqual(arr1, arr2) 
    {
        if(arr1.length !== arr2.length) return false

        let counter = 0

        arr1.forEach(ele1 => arr2.forEach(ele2 => ele1 == ele2 && counter++))   
        
        return arr1.length === counter
    }

    $(".gallery-img").first().addClass("ring-indigo-600 ring-1")

    $(".gallery-img").click(function() {
        $(".main-img").attr("src", $(this).attr("src"))
        $(".gallery-img").removeClass("ring-indigo-600 ring-1")
        $(this).addClass("ring-indigo-600 ring-1")
    })

    $("select").change(function() {
        const optionIds = []

        $("select").each(function() {
            optionIds.push($(this).val());
        })

        product.variations.forEach(variation => {
            if(!isArrayEqual(optionIds, variation.options)) return
            window.location.href = `/products/${variation.id}`
        })
    })

    $(".btn-cart").click(async function() {
        if(!window.user) return alert("You need to login to add the product to your cart")

        if(product.has_variations) return

        const quantity = $("input[name=quantity]").val()

        if(quantity < 1) return alert("Invalid quantity")

        $(this).attr("disabled", true)

        const response = await fetch(`/cart/${product.id}`, {
            method: "post",
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({quantity})
        })

        if(response.status === 200) {
            alert((await response.json()).success)
        } else if(response.status ===  422) {
            alert((await response.json()).error)
        } else {
            alert("Sorry, An unknown error occured")
        }

        $(this).attr("disabled", false)
    })
</script>

@endsection