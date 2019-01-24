@extends('layouts.app')


@section('content')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>--}}

    <link rel="stylesheet" href="{{asset('css/main.css')}}">

    @include('layouts.header')

    <div class="sidebar col-lg-2">
    </div>

    <br><br>

    <div class="main col-lg-7">
        <h2>{{$title}}</h2>
        @foreach($posts as $value)

            <a href="{{"http://blog/post/" . $value["id"]}}" class="item col-lg-6">
                <img class="col-lg-4 " src="{{asset('images/' . $value['path_image'])}}" alt="" width="150px">
                <div class="description col-lg-8">
                    <b>{{$value['title']}}</b>
                   <i class="icon-cancel delete_post delete{{$value["id"]}}" style="float:right; font-size: 30px; color: #A7A7A7;"></i>
                    <br>
                    <b>Категория:</b> {{$value["category"]["name"]}}
                    <div class="text">
                        {!! $value["text_preview"] !!}
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    @include("layouts/sidebar")

    <div class="outher-paginate">
        {{$posts->render()}}
    </div>

    @include("layouts/footer")

@endsection
