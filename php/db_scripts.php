<?php


//.......................................................................................................
// ONE-TIME PEOPLE SCRIPT
//.......................................................................................................


if ( isset($_GET['run_person_script']) && ! get_option('person_script_complete') ) {
    add_action('init', 'build_person_pages_from_csv', 10);
    add_action('init', 'person_script_finished', 20);
}


function build_person_pages_from_csv() {

    $file = fopen("C:\Users\Damien\Downloads\people.csv", "r");

    $iterator = 0;

    while(!feof($file)) {

        // Skip the first csv header line
        if( $iterator > 0) {

            // Getting the line from the csv file
            $line = fgetcsv( $file, 0, "*" );


            // Building the Person page
            $person_name = explode( '|', $line[1] )[0];
            $person_bio = explode( '|', $line[2] )[0];
            $person_category = explode( '|', $line[3] )[0];

            $person_id = wp_insert_post(array (
                'post_type' => 'person',
                'post_category' => array($person_category),
                'post_title' => $person_name,
                'post_content' => $person_bio,
                'post_status' => 'publish',
            ));

            if ($person_id) {
                update_post_meta( $person_id, 'intro', "" );
            };


            // Building the featured image in the Media library and ataching the thumbnail to the Person page
            $image_url = explode( '|', $line[4] )[0];
            $image_title = explode( '|', $line[5] )[0];
            $image_description = explode( '|', $line[6] )[0];
            $image_caption = $image_title;
            $image_alt_text = $image_title . $image_description;
            
            create_featured_image_and_attach_to_post( $image_url, $image_title, $image_caption, $image_alt_text, $image_description, $person_id );


            // Keeping track of the process
            $iterator = $iterator + 1; 
            echo $iterator . ' Person pages succesfully built<br><br>';
            flush();
        }

        else {
            // This is the header line of the csv, we need to call it but won't be needing it
            $line = fgetcsv( $file, 0, "*" );
            $iterator = $iterator + 1; 
        }
    } 
    fclose($file);
}


function create_featured_image_and_attach_to_post( $image_url, $image_title, $image_caption, $image_alt_text, $image_description, $post_id = 0 ){
    
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents( $image_url );
    $filename = basename($image_url);
    if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
    else                                    $file = $upload_dir['basedir'] . '/' . $filename;
    file_put_contents($file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_status' => 'inherit',
        'post_title' => $image_title,
        'post_content' => $image_description,
        'post_excerpt' => $image_caption
    );
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
    update_post_meta( $attach_id, '_wp_attachment_image_alt', $image_alt_text );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    $res1 = wp_update_attachment_metadata( $attach_id, $attach_data );
    $res2 = set_post_thumbnail( $post_id, $attach_id );
}

function person_script_finished() {
    add_option('person_script_complete', 1);
    die("Finished creating the Person pages !");
}




//.......................................................................................................
// ONE-TIME BOOKS SCRIPT
//.......................................................................................................


if ( isset($_GET['run_book_script']) && ! get_option('book_script_complete') ) {
    add_action('init', 'build_book_pages_from_csv', 10);
    add_action('init', 'book_script_finished', 20);
}

 
function build_book_pages_from_csv() {

    $file = fopen("C:\Users\Damien\Downloads\books.csv", "r");

    $iterator = 0;

    while(!feof($file)) {

        // Skip the first csv header line
        if( $iterator > 0) {

            // Getting the line from the csv file
            $line = fgetcsv( $file, 0, "*" );


            // Building the Book page
            $book_title = explode( '|', $line[1] )[0];
            $book_author = explode( '|', $line[2] )[0];
            $book_summary = explode( '|', $line[3] )[0];
            $leslibraires_url = explode( '|', $line[4] )[0];
            $amazon_url = explode( '|', $line[5] )[0];
            $fnac_url = explode( '|', $line[6] )[0];

            $book_id = wp_insert_post(array (
                'post_type' => 'book',
                'post_title' => $book_title,
                'post_status' => 'publish',
            ));

            if ($book_id) {
                update_post_meta( $book_id, 'author', $book_author );
                update_post_meta( $book_id, 'summary', $book_summary );
                update_post_meta( $book_id, 'genre', "" );
                update_post_meta( $book_id, 'theme', "" );
                update_post_meta( $book_id, 'rewards', "" );
                update_post_meta( $book_id, 'leslibraires_url', $leslibraires_url );
                update_post_meta( $book_id, 'amazon_url', $amazon_url );
                update_post_meta( $book_id, 'fnac_url', $fnac_url );
                update_post_meta( $book_id, 'priceminister_url', "" );
                update_post_meta( $book_id, 'recyclivre_url', "" );
                update_post_meta( $book_id, 'ebook_url', "" );
                update_post_meta( $book_id, 'gutenberg_url', "" );
            };


            // Building the featured image in the Media library and ataching the thumbnail to the Book page
            $image_url = explode( '|', $line[7] )[0];
            $image_title = explode( '|', $line[8] )[0];
            $image_description = explode( '|', $line[9] )[0];
            $image_caption = $image_title;
            $image_alt_text = $image_title . $image_description;
            
            create_featured_image_and_attach_to_post( $image_url, $image_title, $image_caption, $image_alt_text, $image_description, $book_id );


            // Keeping track of the process
            $iterator = $iterator + 1; 
            echo $iterator . ' Book pages succesfully built<br><br>';
            flush();
        }

        else {
            // This is the header line of the csv, we need to call it but won't be needing it
            $line = fgetcsv( $file, 0, "*" );
            $iterator = $iterator + 1; 
        }
    } 
    fclose($file);
}


function book_script_finished() {
    add_option('book_script_complete', 1);
    die("Finished creating the Book pages !");
}




//.......................................................................................................
// ONE-TIME RECOMMENDATIONS SCRIPT
//.......................................................................................................


if ( isset($_GET['run_recommendation_script']) && ! get_option('recommendation_script_complete') ) {
    add_action('init', 'build_recommendations_from_csv', 10);
    add_action('init', 'recommendation_script_finished', 20);
}

 
function build_recommendations_from_csv() {

    $file = fopen("C:/Users/Damien/Downloads/recommendations.csv", "r");

    $iterator = 0;

    while(!feof($file)) {

        // Skip the first csv header line
        if( $iterator > 0) {

            // Getting the line from the csv file
            $line = fgetcsv( $file, 0, "*" );

            
            // Building the Recommendation
            $book_title = explode( '|', $line[0] )[0];
            echo $book_title . '<br>';
            $recommender_name = explode( '|', $line[1] )[0];
            echo $recommender_name . '<br>';
            $recommendation_text = explode( '|', $line[2] )[0];
            $sources_titles = explode( '|', $line[3] )[0];
            echo $sources_titles . '<br>';
            $sources_urls = explode( '|', $line[4] )[0];
            echo $sources_urls . '<br>';

            $recommendation_id = wp_insert_term(
                sanitize_title( $recommender_name . ' - ' . $book_title ),    // the Recommendation name
                'recommendation',                   // the taxonomy type
                array(
                    'description'=>$recommendation_text
                )
            );

            print_r( $recommendation_id ) . '<br>';

            if($recommendation_id) {
                update_term_meta( $recommendation_id['term_taxonomy_id'], 'book_title', sanitize_title( $book_title ) );
                update_term_meta( $recommendation_id['term_taxonomy_id'], 'sources_titles', $sources_titles );
                update_term_meta( $recommendation_id['term_taxonomy_id'], 'sources_urls', $sources_urls );
            };
            

            /* THE ATTACHMENT PART DID NOT WORK, SO I DID MANUALLY FOR NOW

            // Attach the Recommendation to the Person page
            $person_args = array(
                'post_type' => 'person',
                'post_status' => 'publish',
                'post_title' => 'Emmanuel Macron',
            );

            // Book Recommendations : Sending the WP_Query
            $wp_query = new WP_Query( $person_args );
            $wp_query->the_post();
            $person_page_id = $wp_query->post->ID;

            $person_bio = $wp_query->post->post_content;

            wp_reset_query();

            //wp_set_object_terms( $person_page_id, $recommendation_id, 'recommendation' );
            do_action( 'add_term_relationship', $person_page_id, $recommendation_id['term_taxonomy_id'], 'recommendation' );

            */

            // Keeping track of the process
            //echo $iterator . '----------------' . $recommender_name . '----------------' . $book_title . '<br>';
            echo '<br>' . $iterator . ' Recommendations succesfully built<br><br>';
            $iterator = $iterator + 1; 
            
            flush();
        }

        else {
            // This is the header line of the csv, we need to call it but won't be needing it
            $line = fgetcsv( $file, 0, "*" );
            $iterator = $iterator + 1; 
        }
    } 
    fclose($file);
}


function recommendation_script_finished() {
    add_option('recommendation_script_complete', 1);
    die("Finished creating the Recommendations !");
}

?>