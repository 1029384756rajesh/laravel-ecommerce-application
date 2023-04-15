<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ecommerce Admin</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
      
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    
    <script src="/assets/app.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        *{
            font-family: 'Poppins', sans-serif;
        }

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
            background-color: rgb(39, 89, 107);
        }

        .page {
            margin-left: 200px;
            margin-top: 56px;
            padding: 12px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary fixed-top" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/admin">Ecommerce Admin</a>
        </div>
    </nav>

    <ul class="sidebar bg-primary">
        <li class="{{ Request::path() == "admin" ? "active" : "" }}">
            <i class="fa fa-home"></i>
            <a href="/admin">Dashboard</a>
        </li>
        <li class="{{ str_starts_with(Request::path(), "admin/sliders") ? "active" : "" }}">
            <i class="fa fa-edit"></i>
            <a href="/admin/sliders">Slider</a>
        </li>
        <li class="{{ str_starts_with(Request::path(), "admin/categories") ? "active" : "" }}">
            <i class="fa fa-list"></i>
            <a href="/admin/categories">Category</a>
        </li>
        <li class="{{ str_starts_with(Request::path(), "admin/products") ? "active" : "" }}">
            <i class="fa fa-tshirt"></i>
            <a href="/admin/products">Product</a>
        </li>
        <li class="{{ str_starts_with(Request::path(), "admin/orders") ? "active" : "" }}">
            <i class="fa fa-bag-shopping"></i>
            <a href="/admin/orders">Order</a>
        </li>
        <li class="{{ str_starts_with(Request::path(), "admin/settings") ? "active" : "" }}">
            <i class="fa fa-gear"></i>
            <a href="/admin/settings">Setting</a>
        </li>
        <li>
            <i class="fa fa-link"></i>
            <a href="/">View Site</a>
        </li>
    </ul>

   <div class="page">
        @if (session()->has("success"))
            <div class="container mt-4 px-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session("success") }}
                    <button type="button" class="btn-close"></button>
                </div>
            </div>
        @endif

        @yield("content")
   </div>
</body>

</html>