<div class="right-sidebar col-lg-3">
    <h2>Топ читаемых</h2>

    @foreach($best_posts as $value)
    <a href="{{"http://blog/post/" . $value["id"]}}">
        <div class="right-sidebar-item col-lg-12">
            <img class="col-lg-4" src="{{asset('images/' . $value['path_image'])}}" alt="" width="200px">
            <div class="description col-lg-8">
                <div class="category">
                    <b>{{$value['title']}}</b>
                </div>
                <div class="category">
                    <b>Категория:</b> {{$value['category']['name']}}
                </div>
                <div class="text">
                    {{$value["text_preview"]}}
                </div>
            </div>
        </div>
    </a>
    @endforeach

</div>
