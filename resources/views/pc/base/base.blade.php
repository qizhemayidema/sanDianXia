<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"> -->
    <meta name="format-detection" content="email=no" />
    <meta name="format-detection" content="telephone=no">
    <title>@yield('title')</title>
    @include('pc.common.source')
    @yield('source')
</head>

<body>
@include('pc.common.header')
@yield('body')
@include('pc.common.footer')
</body>
@yield('js')
</html>