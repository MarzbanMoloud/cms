<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/dropzone.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/dropzone.js"></script>
    <link rel="stylesheet" href="{{asset('/css/sweetalert.css')}}">
    <style>
        .error{
            color: red;
        }


    </style>
    <title>@yield('title')</title>
</head>
<body>
<nav class="navbar navbar-primary pull-right" >
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li><a href="#"> خروج</a></li>
            <li><a href="{{ route('category') }}">مدیریت دسته بندی</a></li>
            <li><a href="#">مدیریت محصولات</a></li>
            <li><a href="#"> افزودن محصول</a></li>
            <li class="active"><a href="#">داشبورد</a></li>
        </ul>
    </div>

</nav>

<div class="container">
    <div class="col-md-12" style="direction: rtl">
        @yield('content')
    </div>
</div> <!-- /container -->

<script src="{{asset('/js/app.js')}}"></script>
<script src="{{asset('/js/sweetalert.js')}}"></script>

</body>

</body>
</html>
