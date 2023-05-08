<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="{{ asset("js/app.js") }}"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <nav class="bg-indigo-600 h-16 shadow-lg px-3 z-50">
        <div class="max-w-5xl mx-auto h-full flex items-center justify-between">
            <a href="/" class="text-2xl text-white font-bold">Ecommerce</a>
            
            <ul id="navMenu" class="nav-menu-close transition-all duration-300 lg:nav-menu-none flex flex-col lg:flex-row bg-indigo-600 lg:bg-inherit py-8 lg:py-0 items-center gap-8 absolute lg:static left-0 right-0 top-16 shadow-md lg:shadow-none">
                <li>
                    <a href="/" class="text-white">Home</a>
                </li>
                <li>
                    <a href="/products" class="text-white">Products</a>
                </li>
                <li>
                    <a href="/contact" class="text-white">Contact</a>
                </li>
                <li>
                    <a href="/about" class="text-white">About</a>
                </li>
            </ul>

            <ul class="flex items-center gap-8">
                <li>
                    <a href="/search" class="fa fa-search text-white text-xl"></a>
                </li>

                @if (auth()->user())
                    <li class="relative">
                        <a href="/cart" class="fa fa-shopping-cart text-white text-xl"></a>
                        {{-- <span class="absolute -top-3 -right-2 bg-white text-sm rounded-full h-5 w-5 flex items-center justify-center"></span> --}}
                    </li>
                @endif

                <li class="relative">
                    <span id="accountIcon" class="fa fa-user cursor-pointer text-white text-xl"></span>

                    <ul id="accountMenu" class="absolute z-50 bg-indigo-600 w-56 right-0 shadow-lg text-white py-3 rounded hidden top-12">
                        @if (auth()->user())
                            <li>
                                <a href="/orders" class="px-6 py-3 inline-block">Orders</a>
                            </li>

                            <li>
                                <a href="/account/edit" class="px-6 py-3 inline-block">Edit Account</a>
                            </li>

                            <li>
                                <a href="/account/password/change" class="px-6 py-3 inline-block">Change Password</a>
                            </li>

                            <li>
                                <a href="/account/logout" class="px-6 py-3 inline-block">Logout</a>
                            </li>
                        @else
                            <li>
                                <a href="/account" class="px-6 py-3 inline-block">Register</a>
                            </li>

                            <li>
                                <a href="/account/login" class="px-6 py-3 inline-block">Login</a>
                            </li>
                        @endif
                    </ul>
                </li>

                <li class="lg:hidden" id="navToggler">
                    <div class="fa fa-bars text-white text-xl cursor-pointer"></div>
                </li>
            </ul>
        </div>
    </nav>

    @if (session()->has('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="alert-danger">{{ session('error') }}</div>
    @endif

    <div class="py-6">
        @yield('content')
    </div>

    <script>
        window.user = @json(auth()->user())
    </script>
</body>

</html>