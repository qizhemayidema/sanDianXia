<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"> -->
    <meta name="format-detection" content="email=no" />
    <meta name="format-detection" content="telephone=no">
    <title>@yield('title')</title>
    @include('pc.common.source')
    <link rel="stylesheet" href="{{ asset('static/admin/js/city/css/pick.css') }}">
    <script src="{{ asset('static/admin/js/city/js/pick.js') }}"></script>
    <style>
        .pick-area1{
            width: 100%!important;
        }
        .pick-show{
            border: 0;
            margin-top: 6px;
        }
        .pick-list{
            width: 337px!important;
        }
    </style>
    @yield('source')
</head>

<body>
@yield('body')
@include('pc.common.storeFooter')
</body>
@yield('js')
</html>