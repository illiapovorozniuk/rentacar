<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <title>@yield('title')</title>
    @yield('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <style>
        :root {
            --main-color: #e53948;
            --additional-color: #e5613a;
        }
    </style>
</head>
<body>
@include('front.template-parts.header')

@yield('body')
@yield('footer')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{ asset('js/front.js') }}"></script>

</body>
</html>
