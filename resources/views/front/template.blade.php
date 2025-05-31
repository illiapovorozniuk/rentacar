<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <title>@yield('title')</title>
    @yield('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Onest:wght@100..900&display=swap" rel="stylesheet">
    <style>
        :root {
            --main-color: #e53948;
            --additional-color: #e5613a;
        }
    </style>
    @yield('fancybox-styles')
</head>
<body>
@include('front.template-parts.header')

@yield('body')
@yield('footer')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
@yield('fancybox')

<script src="{{ asset('js/front.js') }}"></script>

</body>
</html>
