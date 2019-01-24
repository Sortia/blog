


$("#search").keyup(function(event){
    if(event.keyCode === 13){

        let search_text = $(this).val().replace(' ', '+');

        console.log(search_text);

        location.href = "/search?search=" + search_text;

    }
});

$('#comment_submit').on('click', function () {
    let post_id = $('#post_id').val();
    let comment = $('#comment_area').val();

        $.ajax({
            type: "POST",
            url: "/post/" + post_id,
            async: true,
            dataType: 'json',
            data: {
                'comment': comment,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {// в случае удачного завершения запроса к серверу
                let comment = "<div class=\"comment\"><h4 class='comment_name'>" + data['user'] + "</h4><p class='comment_text'>" + data['text'] + "</p><p class='comment_date'>" + data['date'] + "</p></div>";

                $('#comments').prepend(comment);
                console.log(data);
            }
        });
});

$('.delete_post').on('click', function () {

    event.preventDefault(); // отменяем переход к посту

    if(confirm("Удалить?")) {
        let id = event.path[2].href;
        let post_id = id.match(/[0-9]+/)[0];
        let cur_post = event.path[2];

        $.ajax({
            type: "POST",
            url: "/delete_post/" + post_id,
            async: true,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {// в случае удачного завершения запроса к серверу
                $(cur_post).remove();
            }
        });
    }
});

$('.delete_comment').on('click', function () {

    if(confirm("Удалить?")) {
        let cur_comment = event.path[2];
        let comment_id = $(this).attr("class").split(' ')[2].match(/[0-9]+/);

        $.ajax({
            type: "POST",
            url: "/delete_comment/" + comment_id,
            async: true,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                $(cur_comment).remove();
            }
        });
    }

});































