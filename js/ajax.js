(function($) {

    $(".inspirama-carousel-dropdown a").on('click', function (event) {

        // Prevent the # link to send us back to the top of the page
        event.preventDefault();

        // Save the category name and button
        var category_name = $(this).text();
        var category_button = $(this).parents("ul.dropdown-menu").siblings("button");
        
        // Only launch the AJAX call if the seelcted category has changed
        if ( category_button.text() != category_name ) {

            // Update the displayed selected category
            category_button.text(category_name);
            category_button.append( '<span class="caret"></span>' );

            // Save the carousel jquery object
            var books_carousel = $(this).parents('h2').siblings('.inspirama-carousel');

            // The loading gif comes over and hides the carousel item
            var loading_image = books_carousel.find('.ajax-loading');
            loading_image.fadeIn(150);

            // Build the AJAX according to the type of carousel
            var carousel_item_classes = books_carousel.find(".item").children().attr('class');
            var ajax_data = {};
            var ajax_success_callback = new Function();

            if ( carousel_item_classes.indexOf('books-carousel-item') != -1 ){
                ajax_data = {
                    'category_name' : category_name,
                    'action': 'inspirama_get_books_carousel'
                };
                ajax_success_callback = $.update_books_carousel;
            }

            // Ajax call
            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: ajax_data, 
                success: function (response) { 
                    ajax_success_callback( response, books_carousel );
                    loading_image.fadeOut(1000); 
                },
                error: function () {
                    loading_image.fadeOut(1000); 
                }
            });
    
        }
    });

    $.update_books_carousel = function( response, books_carousel ) {

        // Update the content of each of the already-existing books carousel items
        // NB: THIS ASSUMES THERE IS ALWAYS THE SAME NUMBER IN EACH CATEGORY
        books_carousel.find(".item").each(
            function ( i ) { 
                $(this).find(".recommended-book").each(
                    function ( j ) {
                        
                        $(this).find("h3").text( response.selected_books[i][j]['book_title'] );
                        $(this).find("h4").text( response.selected_books[i][j]['book_author'] );
                        $(this).find("a").attr("href", response.selected_books[i][j]['book_url'] );
                        $(this).find("img").attr("src", response.selected_books[i][j]['book_image'] );
                    }); 
            });
    };

})(jQuery)