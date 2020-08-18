
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Mercatodo</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
<!-- Bootstrap core CSS -->
<link href="https://getbootstrap.com/docs/4.5/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<!-- Styles -->
<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
</style>
<!-- Custom styles for this template -->
<link href="https://getbootstrap.com/docs/4.5/examples/pricing/pricing.css" rel="stylesheet">


<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('jquery-3.5.1.min.js')}}"></script>
<script src="{{ asset('/js/validations.js')}}"></script>
<!-- Scripts -->
