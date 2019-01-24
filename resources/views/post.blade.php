@extends('layouts.app')
@section('content')




    @include('layouts.header')


    <div class="page">
        <div class="sidebar col-lg-3"></div>

        <div class="main col-lg-6">

            <h1 style="text-align: center;">{{$post['title']}}</h1>
            <img class="leftimg" src="{{asset("images/" . $post['path_image'])}}" width="400px" alt="">
            {!! $post['text'] !!}


            <h3>{{$post['count_comments']}}</h3>
            <div id="comments">
                @foreach($post['comments'] as $value)
                    <div class="comment">
                        <h4 class='comment_name'>{{$value['user']}}
                            <i class="icon-cancel delete_comment delete_comment{{$value["id"]}}" style="float:right; font-size: 30px; color: #A7A7A7;"></i>
                        </h4>
                        <p class='comment_text'>{{$value['text']}}</p>
                        <p class='comment_date'>{{$value['created_at']}}</p>
                    </div>
                @endforeach
            </div>
            <div class="form">
                <textarea name="comment" id="comment_area" type="text"
                          placeholder="Введите текст комментария"></textarea><br>
                <input id="comment_submit" type="button" value="Отправить">
                <input type="hidden" id="post_id" name="post_id" value="{{$post['id']}}">
            </div>
        </div>



        @include("layouts/sidebar")
        @include("layouts/footer")
    </div>

@endsection
