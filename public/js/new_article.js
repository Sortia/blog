(function () {

    'use strict';

    $('.input-file').each(function () {
        var $input = $(this),
            $label = $input.next('.js-labelFile'),
            labelVal = $label.html();

        $input.on('change', function (element) {
            var fileName = '';
            if (element.target.value)
                fileName = element.target.value.split('\\').pop();

            if (fileName.match(/\.(?:jpg|jpeg|png)$/i) !== null)
                fileName ? $label.addClass('has-file').find('.js-fileName').html(fileName) : $label.removeClass('has-file').html(labelVal);
        });
    });

    $('#article_title').on('keydown', function () {
        $('#placeholder_article_title').text('');
    });

    $('#article_content').on('keydown', function () {
        $('#placeholder_article_content').text('');
    });

    $('#article_title').on('keyup', function () {
        let text = $('#article_title').text();

        if (text !== '')
            $('#placeholder_article_title').text('');
        else $('#placeholder_article_title').text('Введите залоговок');
    });

    $('#article_content').on('keyup', function () {
        let text = $('#article_content').text();

        if (text !== '')
            $('#placeholder_article_content').text('');
        else $('#placeholder_article_content').text('Введите что-нибудь');
    });





    var files; // переменная. будет содержать данные файлов

// заполняем переменную данными, при изменении значения поля file
    $('input[type=file]').on('change', function(){
        files = this.files;
    });



    $('#submit').on('click', function () {

        let title = $('#article_title').html();
        let text = $('#article_content').html();
        let category = $('#select_category').val();
        let img = new FormData();

        console.log(text);

        // заполняем объект данных файлами в подходящем для отправки формате
        $.each( files, function( key, value ){
            img.append( key, value );
        });

        $.ajax({
            type: "POST",
            url: "/add_post",
            async: true,
            dataType: 'json',
            data: {
                'title': title,
                'text': text,
                'category': category,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) { // в случае удачного завершения запроса к серверу
                    $.ajax({
                    url: "/add_post_image/" + data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'text',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: img,
                    type: 'post',
                });
            }
        });



    });









})();