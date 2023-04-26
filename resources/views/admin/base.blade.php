<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield("head")

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
      
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>



    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>

    <link rel="stylesheet" href="/assets/index.css">


    <script src="/assets/app.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset("js/app.js") }}"></script>

    <style>
        /* *{
            font-family: 'Poppins', sans-serif;
        } */

        .sidebar {
            width: 200px;
            background-color: skyblue;
            height: calc(100vh - 56px);
            position: fixed;
            left: 0px;
            top: 56px;
            overflow: hidden;
            z-index: 10;
            list-style-type: none;
            margin: 0px;
            padding: 0px;
        }

        .sidebar > li > a {
            text-decoration: none;
            color: white;
        }

        .sidebar > li {
            padding: 12px 24px;
        }

        .sidebar > li > i {
            color: white;
            margin-right: 12px;
            width: 20px;
        }

        .sidebar > li.active {
            /* background-color: rgb(39, 89, 107); */
            background-color: rgb(12, 62, 80);
        }

        .page {
            margin-left: 200px;
            margin-top: 56px;
            padding: 12px;
        }

        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .gallery-btn-add {
            height: 80px;
            width: 80px;
            border: none;
            background-color: #ccc;
            border: 2px solid #999;
            outline: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #666;
        }

        .gallery-item {
            position: relative;
        }

        .gallery-img {
            height: 80px;
            width: 80px;
            object-fit: cover;
            display: block;
            border: 2px solid #999;
        }

        .gallery-btn-remove {
            position: absolute;
            inset: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 300ms;
            font-size: 24px;
        }

        .gallery-item:hover .gallery-btn-remove {
            display: flex;
        }

        .product-img {
            height: 80px;
            width: 80px;
            background-color: #ccc;
            border: 2px solid #999;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #666;
        }

        /* .lfm-btn,
        .lfm-btn-multiple {
            height: 100px; 
            width: 100px;
            cursor: pointer;
        }

        .lfm-close {
            background-color: rgba(0, 0, 0, 0.6);
            font-size: 24px;
        }

        .lfm-container:hover .lfm-close {
            display: flex !important;
        }
        .lfm-mul-container:hover i {
            display: flex !important;
        } */
    </style>
</head>

<body>
    <nav class="bg-indigo-600 h-16 px-6 flex items-center justify-between shadow-md fixed top-0 left-0 right-0" data-bs-theme="dark">
        <a class="text-white text-xl font-bold" href="/admin">Rmart Admin</a>
        <i class="fa fa-bars text-xl text-white block lg:hidden cursor-pointer" id="navMenu"></i>
    </nav>

    <ul id="sidebar" class="bg-indigo-600 w-56 h-[calc(100vh-64px)] fixed -left-56 transition-all duration-300 lg:left-0 top-16">
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
        <li class="text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent {{ str_starts_with(Request::path(), "admin/orders") ? "bg-indigo- border-l-indigo-600" : "" }}">
            <i class="fa fa-bag-shopping w-6"></i>
            <a href="/admin/orders">Order</a>
        </li>
        <li class="text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent {{ str_starts_with(Request::path(), "admin/users") ? "bg-indigo-700 border-l-indigo-600" : "" }}">
            <i class="fa fa-user w-6"></i>
            <a href="/admin/orders">User</a>
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
            <div class="bg-green-100 text-green-600 rounded p-4">{{ session("success") }}</div>
        @endif

        @yield("content")
   </div>
</body>

</html>