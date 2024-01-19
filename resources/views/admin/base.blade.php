<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield("head")
      
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sortable/0.9.13/jquery-sortable-min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>    

    <link href="{{ asset("css/app.css") }}" rel="stylesheet">

    <script src="{{ asset("js/admin.js") }}"></script>
</head>

<body class="font-poppins">
    <nav class="z-50 bg-indigo-600 h-16 px-6 flex items-center justify-between shadow-md fixed top-0 left-0 right-0">
        <a class="text-white text-xl font-bold" href="/admin">Rmart Admin</a>
        <i class="nav-toggler fa fa-bars text-xl text-white block lg:hidden cursor-pointer"></i>
    </nav>

    <ul class="sidebar bg-indigo-600 w-56 h-[calc(100vh-64px)] fixed -left-56 transition-all duration-300 lg:left-0 top-16">
        <li class="text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent {{ Request::path() == "admin" ? "bg-indigo-700 border-l-indigo-900" : "" }}">
            <i class="fa fa-home w-6"></i>
            <a href="/admin">Dashboard</a>
        </li>
        
        <li class="text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent {{ str_starts_with(Request::path(), "admin/sliders") ? "bg-indigo-700 border-l-indigo-900" : "" }}">
            <i class="fa fa-edit w-6"></i>
            <a href="/admin/sliders">Slider</a>
        </li>

        <li class="text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent {{ str_starts_with(Request::path(), "admin/categories") ? "bg-indigo-700 border-l-indigo-900" : "" }}">
            <i class="fa fa-list w-6"></i>
            <a href="/admin/categories">Category</a>
        </li>

        <li class="text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent {{ str_starts_with(Request::path(), "admin/products") ? "bg-indigo-700 border-l-indigo-900" : "" }}">
            <i class="fa fa-tshirt w-6"></i>
            <a href="/admin/products">Product</a>
        </li>

        <li class="text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent {{ str_starts_with(Request::path(), "admin/orders") ? "bg-indigo-700 border-l-indigo-600" : "" }}">
            <i class="fa fa-bag-shopping w-6"></i>
            <a href="/admin/orders">Order</a>
        </li>

        <li class="text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent {{ str_starts_with(Request::path(), "admin/users") ? "bg-indigo-700 border-l-indigo-600" : "" }}">
            <i class="fa fa-user w-6"></i>
            <a href="/admin/users">User</a>
        </li>

        <li class="text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent {{ str_starts_with(Request::path(), "admin/settings") ? "bg-indigo-700 border-l-indigo-600" : "" }}">
            <i class="fa fa-gear w-6"></i>
            <a  href="/admin/settings">Setting</a>
        </li>
        
        <li class="text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent">
            <i class="fa fa-link w-6"></i>
            <a href="/">View Site</a>
        </li>
    </ul>

   <div class="pt-20 px-4 pb-4 ml-0 lg:ml-56">
        @if (session()->has("success"))
            <div class="alert-success mb-3">{{ session("success") }}</div>
        @endif

        @yield("content")
   </div>
</body>
</html>