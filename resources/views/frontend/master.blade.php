<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('CSS/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/header.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/map.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/banner.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/main.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/bid.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/QA.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/my_office.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/success.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>صكوك سعودي</title>
    </head>
    <body>
        @include('frontend.layouts.header')
        <div class="content">
        @yield('content')
        </div>
        @include('frontend.layouts.footer')
    <script src="{{ asset('JS/index.js') }}"></script>
    <script src="{{ asset('JS/map.js') }}"></script>
    <script src="{{ asset('JS/QA.js') }}"></script>
    <script src="{{ asset('JS/success.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
