@extends('layouts.app')
@section('content')

    <link rel="stylesheet" href="{{asset("css/article.css")}}">
    <script src="{{ asset('js/new_article.js') }}" defer></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <div class="container">

        <form id="new_post_form" action="/" method="POST">

            <div class="edit">
                <h1 contenteditable id="article_title"></h1>
                <div contenteditable id="article_content" class="text"></div>
            </div>

            <div id="placeholder_edit">
                <h1 id="placeholder_article_title" class="labeled">Введите залоговок</h1>
                <div id="placeholder_article_content" class="text">Введите еще немного текста</div>
            </div>

            <div class="for_align_right">

                <select id="select_category" class="select_category" name="category">
                    @foreach($categories as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                </select>

                <div class="example-2">
                    <div class="form-group">
                        <input type="file" name="file" id="file" class="input-file">
                        <label for="file" class="btn btn-tertiary js-labelFile">
                            <i class="icon fa fa-check"></i>
                            <span class="js-fileName">Загрузить картинку</span>
                        </label>
                    </div>
                </div>

                <input id="submit" type="button" value="Отправить">
            </div>

        </form>

    </div>

@endsection
