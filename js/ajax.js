(function($) {

    $("#books-carousel-people-categories a").on('click', function (event) {

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
            var books_carousel = $(this).parents('h2').siblings('.carousel.slide');

            // The loading gif comes over and hides the carousel item
            $('#loading-image').fadeIn(150);

            // Ajax call
            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: {
                    'action': 'inspirama_get_books_carousel'
                }, 

                success: function (response) {

                    // Update the content of each of the already-existing carousel items
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

                    // The loading gif progressively disappears
                    $('#loading-image').fadeOut(1000);
                },

                error: function () {}
            });
        }
    });

})(jQuery)