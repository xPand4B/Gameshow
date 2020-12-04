<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('_partials.head')
</head>
<body class="antialiased @yield('master.body.class')">

    <noscript>This page needs JavaScript activated to work.</noscript>

    @yield('master.content')

    @include('_partials.javascript')
</body>
</html>
