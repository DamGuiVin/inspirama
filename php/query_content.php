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
// Recovers the top recommendations along with book and people data 
// NB : extract_blockquotes_content() ignores the recommendations without blockquotes
//.......................................................................................................

function get_top_recommendations() {

    $top_books = array(  
        'les-freres-karamazov', 
        'le-cycle-de-fondation-tome-2-fondation-et-empire',
        'vagabonding',
        'le-petit-prince');

    $top_books_recommendations = array();

    foreach( $top_books as $book ) {
        array_push( $top_books_recommendations, get_book_recommendations( $book, true ) );
    }

    return $top_books_recommendations;
}


//.......................................................................................................
// Recovers all info necessary for the recommendations associated with the input book slug
//.......................................................................................................

function get_book_recommendations( $book_slug, $only_blockquotes = false ) {

    // The array we will use to output the data
    $book_recommendations = array();

    // Getting the books info before calling the associated people and recommendations
    $args = array(
        'post_type' => 'book',
        'name' => $book_slug,
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'rand'
        );

    $book_query = new WP_Query( $args );

    if ( $book_query->have_posts() ) {
        while ( $book_query->have_posts() ) {

            // Iterating on the WP post loop
            $book_query->the_post();
            $book_id = $book_query->post->ID;

            // Getting data about the book
            $book_recommendations = get_book_data( $book_id, true, true );

            // Getting the ids of the recommendations associated with the book
            $recommendations_ids = get_recommendations_ids_from_book_slug( $book_recommendations['book_slug'] );

            // Getting the data about each of the recommendations
            $recommendations_data = array();
            foreach( $recommendations_ids as $recommendation_id) {
                $one_recommendation_data = get_recommendation_data( $recommendation_id, $only_blockquotes );
                if( $one_recommendation_data ) { array_push( $recommendations_data, $one_recommendation_data ); }
            }
            $book_recommendations['recommendations'] = $recommendations_data;
        }
    }

    return $book_recommendations;
}


//.......................................................................................................
// Recovers the ID of the recommendation associated with the input book slug
// NB : assumes unicity of the book 
//.......................................................................................................

function get_recommendations_ids_from_book_slug( $book_slug ) {

    $all_recommendations = get_terms( array( 'taxonomy' => 'recommendation', 'orderby' => 'name' ));

    $recommendations_ids = array();

    foreach( $all_recommendations as $term ) {
        
        $associated_book = get_term_meta( $term->term_id, 'book_title', true );
        
        if( $associated_book == $book_slug ) { $recommendations_ids[] = $term->term_id; }
    }

    return $recommendations_ids;
}


//.......................................................................................................
// Recovers the data for the RECOMMENDATION - PERSON pair (not the book), from the reco ids
// NB : assumes unicity of the person 
//.......................................................................................................

function get_recommendation_data( $recommendation_id, $only_blockquotes = false ) {

    // The associative array of data holding the recommendation and the person attached
    // If the recommendation text is empty, the array will be returned empty
    $recommendation_data = array();

    $recommendation_object = get_term_by( 'id', $recommendation_id, 'recommendation' );
    $recommendation_text = $recommendation_object->description;

    // If required, extract and concatenate only the text in blockquotes, if any 
    if( $only_blockquotes ) {
        $recommendation_text = extract_blockquotes_content( $recommendation_text );
    }
    
    // Only keep the recommendation if it contains a text
    if ( $recommendation_text != '' ) {

        // Recover all the person data
        $recommendation_data = get_recommender_data_from_recommendation_id( $recommendation_id );
        
        // Add the recommendation data
        $recommendation_data['text'] = $recommendation_text;
        $recommendation_data['sources_titles'] = explode( ';', get_term_meta( $recommendation_id, 'sources_titles', true) );
        $recommendation_data['sources_urls'] =  explode( ';', get_term_meta( $recommendation_id, 'sources_urls', true) );
    }     
    
    return $recommendation_data;
}


//.......................................................................................................
// Recovers the PERSON data from te recommendation ID
// NB : assumes unicity of the person 
//.......................................................................................................

function get_recommender_data_from_recommendation_id( $recommendation_id ) {

    // The array of recommender data we will return
    // There should normally be only 1 person associated with 1 recommendation ID
    $recommender = array();

    // Getting the people (there should only be one!) associated to the recommendation
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
                'terms'    => $recommendation_id,
            ),
        ),
    );

    $people_query = new WP_Query( $args );
    
    if ( $people_query->have_posts() ) {
        while ( $people_query->have_posts() ) {

            // Increment the post in $people_query
            $people_query->the_post();

            // Recover person information
            $person_post = $people_query->post;
            $person_id = $person_post->ID;
            $person_name = $person_post->post_title;
            $person_introduction = get_post_meta( $person_id, 'introduction', true);
            $person_image = wp_get_attachment_image_src( get_post_thumbnail_id( $person_id ) )[0];
            $person_url = get_the_permalink( $person_id );

            $recommender = array(
                'person_name' => $person_name,
                'person_introduction' => $person_introduction,
                'person_image' => $person_image,
                'person_url' => $person_url );
        }
    }

    return $recommender;
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

            $iterator++;

            // Iterating on the WP post loop
            $book_query->the_post();
            $book_id = $book_query->post->ID;

            // Getting data about the book
            $book_data = get_book_data( $book_id, false, false );

            // Building the batches
            array_push( $books_batch, $book_data );
            if ( $iterator == $books_per_batch ) {
                array_push( $top_books, $books_batch );
                $books_batch = array();
                $iterator = 0;
            }
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

            $iterator++;

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

            if ( $iterator == $people_per_batch ) {
                array_push( $top_people, $people_batch );
                $people_batch = array();
                $iterator = 0;
            }
        }
    }

    return $top_people;
}


//.......................................................................................................
// Book : Recover all the data for a book
//.......................................................................................................

function get_book_data( $book_id, $with_details = false, $with_affiliation = false ) {

    $book_data['book_title'] = get_the_title($book_id );
    $book_data['book_slug'] = get_post_field( 'post_name', $book_id );
    $book_data['book_author'] = get_post_meta( $book_id, 'author', true);
    $book_data['book_image'] = wp_get_attachment_image_src( get_post_thumbnail_id( $book_id ), 'full' )[0];
    $book_data['book_url'] = get_the_permalink( $book_id );
    
    if( $with_details ) {
        $book_data['book_summary'] = get_post_meta( $book_id, 'summary', true);
        $book_data['book_genre'] = get_post_meta( $book_id, 'genre', true);
        $book_data['book_theme'] = get_post_meta( $book_id, 'theme', true);
        $book_data['book_rewards'] = get_post_meta( $book_id, 'rewards', true);
    }
    
    if( $with_affiliation ) {
        $book_data['book_affiliation'] = get_affiliation_data( $book_id );
    }

    return $book_data;
}


//.......................................................................................................
// Book : Recover the affiliation information for a book
//.......................................................................................................

function get_affiliation_data( $book_id ) {

    $affiliation_data = array();

    $brands_slugs = array(
        'leslibraires',
        'amazon',
        'fnac',
        'priceminister',
        'recyclivre',
        'ebooks',
        'gutenberg' );

    $brands_names = array(
        'Les Libraires',
        'Amazon',
        'La Fnac',
        'Price Minister',
        'Recyclivre',
        'eBooks',
        'Gutenberg Project' );

    foreach ( $brands_slugs as $i => $brand ) {

        $url = get_post_meta( $book_id, $brand . '_url', true );
        $logo = get_stylesheet_directory_uri() . '/img/' . $brand . '.png' ;

        if ( $url ) {
            array_push( $affiliation_data, array( $brands_names[$i], $url, $logo ) );
        }
    }

    return $affiliation_data;
}


?>