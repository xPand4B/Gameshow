@extends('layouts.error')

@section('error.style')
    <link type="text/css" rel="stylesheet" href="{{ url(asset('css/admin.css')) }}">

    <style>
        .page_404 {
            padding:40px 0;
            background:#fff;
        }

        .page_404 img {
            width:100%;
        }

        .four_zero_four_bg {
            background-image: url("{{ asset('img/404-errors/lost/dribbble_1.gif') }}");
            height: 400px;
            background-position: center;
        }

        .four_zero_four_bg h1 {
            font-size:80px;
        }

        .four_zero_four_bg h3 {
            font-size:80px;
        }

        .link_404 {
            color: #fff!important;
            padding: 10px 20px;
            background: #39ac31;
            margin: 20px 0;
            display: inline-block;
        }

        .content_box_404 {
            margin-top:-50px;
        }
    </style>
@endsection

@section('error.content')
    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="col-sm-10 offset-sm-1 text-center">
                        <div class="four_zero_four_bg">

                        </div>
                        <div class="content_box_404">
                            <h3 class="h2">
                                @lang('errors.404.lost.title')
                            </h3>

                            <p>@lang('errors.404.lost.text')</p>

                            <a href="{{ url('/') }}" class="link_404">@lang('errors.404.back-home')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
