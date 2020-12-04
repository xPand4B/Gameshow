@extends('layouts.master')

@section('master.head.title')
    @section('error.title')
        404 Not Found
    @show
@endsection

@section('master.stylesheets')
    @yield('error.style')
@endsection

@section('master.content')
    @yield('error.content')
@endsection

@section('master.javascript')
    @yield('error.javascript')
@endsection
