<html>

<head>
    @include('layouts.head')
</head>

<body>

<header>
    @include('layouts.header')
</header>

<body>
<main class="py-4">
    @yield('content')
</main>
</body>

<footer class="row">
    @include('layouts.footer')
</footer>

</body>

</html>
