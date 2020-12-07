<base href="{{ url('/') }}/">

@section('master.head.meta')
    <meta charset="utf-8"/>
    <meta name="author" content="Eric Heinzl"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=no, user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
@endsection
@yield('master.head.meta')

{{-- CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('master.stylesheets')
    <link type="text/css" rel="stylesheet" href="{{ url(mix('css/app.css')) }}"/>
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css"/>
@endsection
@yield('master.stylesheets')

<title>
    @section('master.head.title')
        {{ config('app.name') }}

        @hasSection ('master.title')
            | @yield('master.title')
        @endif
    @endsection
    @yield('master.head.title')
</title>
