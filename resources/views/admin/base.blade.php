<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel Booking</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

      <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" 
        rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" 
        crossorigin="anonymous"
    >
    <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"
>
</script>
    <style>
*{
    font-family: 'Poppins', sans-serif;
}
.btn-light{
    background-color: #ccc;
}
.option-separator{
    border-right:1px solid gray; padding-right:8px; margin-right:4px;
}
/* .font-base{
    font-size: 16px;
} */
/* .form-control{
    border-radius: 6px !important;
    padding: 8px !important;
    border: 1px solid #d1d5db !important;
    width: 100% !important;
    display: block !important;
    outline: none !important;
} */
/* .my-card {
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background-color: white;
}
.sidebar li {
    padding: 10px 24px;
    border-bottom: 1px solid rgb(172, 169, 169); 
    cursor: pointer;
}

.sidebar li.active{
    background-color: tomato;
    color: white;
}

.sidebar li:last-child{
    border-bottom: 0px;
}
.form-check{
    gap: 16px;
}
.checkbox {
    border-color: #8c8989;
    height: 18px;
    width: 18px;
    border-radius: 4px
}
.checkboxcontainer{
    display: flex;
    align-items: center;
    gap: 12px;
}
.form-la{
    margin-bottom: 6px;
}
.my-header{
    padding: 16px 24px;
    font-weight: bold;
    color: tomato;
    font-size: 18px;
    border-bottom: 1px solid #d1d5db;
}
.my-footer{
    padding: 16px 24px;
    border-top: 1px solid #d1d5db;
}
.my-btn{
    border-radius: 6px;
    background-color: tomato;
    text-align: center;
    font-size: 16px;
    padding: 8px 16px;
    border: none;
    color: white;
}
.form-control-unstyle{
    appearance: none;border:none;outline:none;width:100%;display:block;
} */
.form-control-unstyle{
    appearance: none;border:none;outline:none;width:100%;display:block;
} 
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body style="background-color: #f3f4f6;">

    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('admin.index') }}">MYStudio Admin</a>
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

    @yield('content')



</body>

</html>