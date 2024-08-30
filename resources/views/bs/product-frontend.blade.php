<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample Form</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> -->
    <!-- <script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <div class="max-w-6xl px-3 mx-auto my-4">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 md:col-span-4">
                <img src="{{ $product['details']['images'][0]['src'] }}"
                    class="border border-gray-300 object-cover w-full">
                <div class="grid grid-cols-4 gap-2 mt-2">
                    @foreach ($product['details']['images'] as $image)
                        <img src="{{ $image['src'] }}"
                            class="border border-gray-300 rounded-md object-cover w-full cursor-pointer hover:ring-2 hover:ring-indigo-600 transition-all duration-300">
                    @endforeach
                </div>
            </div>
            <div class="col-span-12 md:col-span-8">
                <h4 class="font-bold text-lg">{{ $product['name'] }}</h4>
                <p class="font-bold text-indigo-600 text-xl mt-2">₹ {{ $product['details']['price'] }}</p>
                <p class="mt-2 text-gray-600">{{ $product['short_description'] }}</p>

                @foreach ($product['attributes'] as $attribute)
                    <b class="mt-4 inline-block font-bold">{{ $attribute['name'] }}:
                        {{ $attribute['options'][0]['name'] }}</b>

                    <div class="flex gap-3 mt-1.5">
                        @foreach ($attribute['options'] as $option)
                            @if ($attribute['type'] == "color")
                                <div class="h-9 w-9 rounded-full cursor-pointer {{ $loop->index === 0 ? 'ring-2 ring-offset-2 ring-indigo-600' : null}}"
                                    style="background-color: {{$option['value']}};">
                                </div>
                            @endif

                            @if ($attribute['type'] == "image")
                                <img class="rounded-md border h-14 w-10 object-cover cursor-pointer border-gray-300 hover:ring-2 hover:ring-indigo-600 transition-all duration-300 {{ $loop->index === 0 ? 'ring-2 ring-indigo-600' : null}}"
                                    src="{{ $option['value'] }}">
                            @endif

                            @if ($attribute['type'] == "label")
                                <button class="px-3 py-1.5 rounded border-gray-400 text-gray-400"
                                    style="border-width: 1px;">{{ $option['name'] }}</button>
                            @endif
                        @endforeach
                    </div>
                @endforeach
                <b class="block mt-4">Quantity: </b>
                <div class="h-9 inline-flex mt-1.5">
                    <button
                        class="w-9 flex items-center justify-center cursor-pointer focus:ring-2 focus:ring-indigo-600 rounded-l-md border border-gray-300">
                        <i class="bi bi-plus text-lg"></i>
                    </button>
                    <div class="w-9 flex items-center justify-center border-t border-b border-gray-300">1</div>
                    <button
                        class="w-9 flex items-center justify-center cursor-pointer focus:ring-2 focus:ring-indigo-600 rounded-r-md border border-gray-300">
                        <i class="bi bi-dash text-lg"></i>
                    </button>
                </div>
                <div class="flex gap-3 mt-4">
                    <button class="px-3 py-1.5 rounded-md bg-indigo-600 font-medium text-white flex items-center gap-2"><i class="bi bi-cart"></i> <span>Add To Cart</span></button>
                    <button class="px-3 py-1.5 rounded-md bg-gray-200 font-medium flex items-center gap-2"><i class="bi bi-suit-heart"></i> <span>Add To Wishlist</span></button>
                </div>
            </div>
        </div>

        <ul class="flex border border-gray-300 rounded-t-md mt-8 overflow-x-auto">
            <li>
                <a class="px-4 py-3 inline-block border-r border-gray-300 text-indigo-600 font-medium" href="#">Description</a>
            </li>
            <li>
                <a class="px-4 py-3 inline-block border-r border-gray-300 font-medium" href="#">Dimension</a>
            </li>
            <li>
                <a class="px-4 py-3 inline-block border-r border-gray-300 font-medium" href="#">Details</a>
            </li>
            <li>
                <a class="px-4 py-3 inline-block border-r border-gray-300 font-medium" href="#">Refund</a>
            </li>
            <li>
                <a class="px-4 py-3 inline-block font-medium" href="#">Reviews</a>
            </li>
        </ul>
        <div class="border border-t-0 border-gray-300 p-4">
            {!! $product['description'] !!}
        </div>
    </div>
</body>

<script>

</script>