<!DOCTYPE html>
<html dir="ltr" lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon.png')}}">
    <title>@yield('title')</title>

    <link href="{{asset('css/fontawesome-all.css')}}" rel="stylesheet" />
    <link href="{{asset('css/simple-line-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('css/themify-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    @yield('css')
   
</head>

<body>
  
    @yield('contain')
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{asset('js/main.js')}}"></script>
    @yield('js')
</body>

</html>