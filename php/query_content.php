<?php 

//.......................................................................................................
// Homepage typing title : Recovers the randomized list of people names and appends 'CEUX QUI VOUS INSPIRENT'
//.......................................................................................................

function get_all_people_names() {

    global $wpdb;
    $custom_post_type = 'person';
    $results = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type = %s and post_status = 'publish'", $custom_post_type ), ARRAY_A );

    if ( ! $results )
        return;

    $list_names = [];
    foreach( $results as $index => $post ) {
        array_push( $list_names, ' ' . mb_strtoupper( $post['post_title'] ) );
    }

    shuffle( $list_names );
    array_unshift( $list_names, ' CEUX QUI VOUS INSPIRENT' );

    return $list_names;
}

//.......................................................................................................
// Recovers all info necessary for the recommendations associated with the input book slugs 
// NB : extract_blockquotes_content() ignores the recommendations without blockquotes
//.......................................................................................................

function get_top_recommendations( $array_book_names ) {

    // The array we will use to output the data
    $top_recommendations = array();

    // The recommendations IDs
    $all_recommendations = get_terms( array( 'taxonomy' => 'recommendation', 'orderby' => 'name' ));

    // Getting the books info before calling the associated people and recommendations
    $args = array(
        'post_type' => 'book',
        'post_name__in' => $array_book_names,
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'rand'
        );

    $books_query = new WP_Query( $args );

    if ( $books_query->have_posts() ) {
        while ( $books_query->have_posts() ) {

            // Saving info about the current book
            $books_query->the_post();
            $book_post = $books_query->post;
            $book_id = $book_post->ID;
            $book_slug = $book_post->post_name;
            $book_title = $book_post->post_title;
            $book_author = get_post_meta( $book_id, 'author', true);
            $book_image = wp_get_attachment_image_src( get_post_thumbnail_id( $book_id ), 'full' )[0];
            $book_url = get_the_permalink( $book_id );

            $current_book = array(
                'book_title' => $book_title,
                'book_author' => $book_author,
                'book_image' => $book_image,
                'book_url' => $book_url );

            // Getting the recommendations about the current book
            $recommendations_ids = array();
            foreach( $all_recommendations as $term ) {
                $key = get_term_meta( $term->term_id, 'book_title', true );
                if( $key == $book_slug ) {
                    $recommendations_ids[] = $term->term_id;
                }
            }

            // Getting the people from the recommendations
            $args = array(
                'post_type' => 'person',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
                'tax_query' => array(
                        array(
                        'taxonomy' => 'recommendation',
                        'field'    => 'term_id',
                        'terms'    => $recommendations_ids,
                    ),
                ),
            );

            $people_query = new WP_Query( $args );
            
            if ( $people_query->have_posts() ) {

                $iterator = 0;
                $current_recommendation_array = array();

                while ( $people_query->have_posts() ) {

                    // Increment the post in $people_query
                    $people_query->the_post();
                    
                    // Recover useful attributes from the Recommendation
                    $recommendation_id = $recommendations_ids[ $iterator ];
                    $recommendation = get_term_by( 'id', $recommendation_id, 'recommendation' );
                    $recommendation_text = extract_blockquotes_content( $recommendation->description );
                    
                    // Only keep the recommendation if it contains a blockquote
                    if ( $recommendation_text != '' ) {
                        $recommendation_sources_titles = explode( ';', get_term_meta( $recommendation_id, 'sources_titles', true) );
                        $recommendation_sources_urls =  explode( ';', get_term_meta( $recommendation_id, 'sources_urls', true) );

                        // Recover person information
                        $person_post = $people_query->post;
                        $person_id = $person_post->ID;
                        $person_name = $person_post->post_title;
                        $person_introduction = get_post_meta( $person_id, 'introduction', true);
                        $person_image = wp_get_attachment_image_src( get_post_thumbnail_id( $person_id ) )[0];
                        $person_url = get_the_permalink( $person_id );

                        $current_recommendation = array(
                            'person_name' => $person_name,
                            'person_introduction' => $person_introduction,
                            'person_image' => $person_image,
                            'person_url' => $person_url,
                            'text' => $recommendation_text,
                            'sources_titles' => $recommendation_sources_titles,
                            'sources_urls' => $recommendation_sources_urls );

                        array_push( $current_recommendation_array, $current_recommendation );
                    }
                    
                    $iterator = $iterator + 1;        
                } 
                $current_book['recommendations'] = $current_recommendation_array;
            }
            array_push( $top_recommendations, $current_book);
        }
    }
    return $top_recommendations;
}

//.......................................................................................................
// Recommendations : extracts the text within blockquotes, strips the blockquotes
// and concatenates the results
//.......................................................................................................

function extract_blockquotes_content( $html_text ) {

    preg_match_all('#<blockquote>(.+)<\/blockquote>#i', $html_text, $matches);
    
    $blockquotes_content = '';

    if ( !empty( $matches[0] ) ) {
        foreach ( $matches[1] as $i => $quote) {
            if ( $i > 0 ) {
                $blockquotes_content .= ' [...] ';
            }
            $blockquotes_content .= $quote ; 
        }
    }

    return $blockquotes_content;
}

//.......................................................................................................
// Recover the top books within a given category 
// NB : THIS IS NOT FULLY FUNCTIONAL YET AS IT ONLY RETURNS RANDOM BOOKS
//.......................................................................................................

function get_top_books( $people_category_name = 'all', $books_per_batch = 5, $num_batches = 3 ) {

    $top_books = array();
    $books_batch = array();
    $iterator = 0;

    $args = array(
        'post_type' => 'book',
        'post_status' => 'publish',
        'posts_per_page' => $books_per_batch * $num_batches,
        'orderby' => 'rand'
        );

    $books_query = new WP_Query( $args );

    if ( $books_query->have_posts() ) {
        while ( $books_query->have_posts() ) {

            // Saving info about the current book
            $books_query->the_post();
            $book_post = $books_query->post;
            $book_id = $book_post->ID;
            $book_title = $book_post->post_title;
            $book_author = get_post_meta( $book_id, 'author', true);
            $book_image = wp_get_attachment_image_src( get_post_thumbnail_id( $book_id ), 'full' )[0];
            $book_url = get_the_permalink( $book_id );

            array_push( $books_batch,  array(
                'book_title' => $book_title,
                'book_author' => $book_author,
                'book_image' => $book_image,
                'book_url' => $book_url ));

            if ( $iterator == ( $books_per_batch - 1 )) {
                array_push( $top_books, $books_batch );
                $books_batch = array();
                $iterator = 0;
            }

            $iterator++;
        }
    }

    return $top_books;
}


//.......................................................................................................
// Recover the top people within a given category 
// NB : THIS IS NOT FULLY FUNCTIONAL YET AS IT ONLY RETURNS RANDOM PEOPLE
//.......................................................................................................

function get_top_people( $people_per_batch = 4, $num_batches = 3 ) {

    $top_people = array();
    $people_batch = array();
    $iterator = 0;

    $args = array(
        'post_type' => 'person',
        'post_status' => 'publish',
        'posts_per_page' => $people_per_batch * $num_batches,
        'orderby' => 'rand'
        );

    $people_query = new WP_Query( $args );

    if ( $people_query->have_posts() ) {
        while ( $people_query->have_posts() ) {

            // Saving info about the current person
            $people_query->the_post();
            $person_post = $people_query->post;
            $person_id = $person_post->ID;
            $person_name = $person_post->post_title;
            $person_intro = get_post_meta( $person_id, 'introduction', true);
            $person_image = wp_get_attachment_image_src( get_post_thumbnail_id( $person_id ), 'full' )[0];
            $person_url = get_the_permalink( $person_id );

            array_push( $people_batch,  array(
                'person_name' => $person_name,
                'person_intro' => $person_intro,
                'person_image' => $person_image,
                'person_url' => $person_url ));

            if ( $iterator == ( $people_per_batch - 1 )) {
                array_push( $top_people, $people_batch );
                $people_batch = array();
                $iterator = 0;
            }

            $iterator++;
        }
    }

    return $top_people;
}

?>