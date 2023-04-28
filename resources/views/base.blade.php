<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <script src="{{ asset("js/app.js") }}"></script>

   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   <style>

       


    </style>
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

                <li class="relative">
                    <a href="/cart" class="fa fa-shopping-cart text-white text-xl"></a>
                    <span class="absolute -top-3 -right-2 bg-white text-sm rounded-full h-5 w-5 flex items-center justify-center">5</span>
                </li>

                <li class="relative">
                    <span id="accountIcon" class="fa fa-user cursor-pointer text-white text-xl"></span>

                    <ul id="accountMenu" class="absolute bg-indigo-600 w-56 right-0 shadow-lg text-white py-3 rounded hidden top-12">
                        <li>
                            <a href="/orders" class="px-6 py-3 inline-block">Orders</a>
                        </li>

                        <li>
                            <a href="/wishlist" class="px-6 py-3 inline-block">Wishlist</a>
                        </li>

                        <li>
                            <a href="/auth/edit-account" class="px-6 py-3 inline-block">Edit Account</a>
                        </li>

                        <li>
                            <a href="/auth/change-password" class="px-6 py-3 inline-block">Change Password</a>
                        </li>

                        <li>
                            <a href="/auth/logout" class="px-6 py-3 inline-block">Logout</a>
                        </li>
                    </ul>
                </li>

                <li class="lg:hidden" id="navToggler">
                    <div class="fa fa-bars text-white text-xl cursor-pointer"></div>
                </li>
            </ul>
        </div>
    </nav>

    @if (session()->has('success'))
        <div class="container mt-4 px-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="container mt-4 px-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="py-6">
        @yield('content')
    </div>


    <script>
        window.user = @json(auth()->user())
    </script>
</body>

</html>