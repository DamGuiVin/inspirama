(function($) {

    $("#pick-person").on('click', function () {

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                'post-type': 'person',
                'action': 'inspirama_get_random_person'
            }, success: function (response) {

               $("#picked-name").text(response.name);
               $("#picked-intro").text(response.intro);
               $("#picked-portrait").attr("src", response.image);
            },
            error: function () {
                $("#picked-name").text(response.error);
                $("#picked-intro").text("");
                $("#picked-portrait").attr("src", "");
            }
        });

    });

    $("#pick-book").on('click', function () {

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                'post-type': 'book',
                'action': 'inspirama_get_random_book'
            }, success: function (response) {

               $("#picked-title").text(response.title);
               $("#picked-author").text(response.author);
               $("#picked-cover").attr("src", response.cover);
            },
            error: function () {
                $("#picked-title").text(response.error);
                $("#picked-author").text("");
                $("#picked-cover").attr("src", "");
            }
        });

    });

})(jQuery)