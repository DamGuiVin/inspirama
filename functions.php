<?php

//.......................................................................................................
// Oren-child theme settings
//.......................................................................................................

// Declaring the child theme style after the parent style
function my_theme_enqueue_styles() {

	// Enqueue parent theme's style.css (faster than using @import in our style.css)
	$themeVersion = wp_get_theme()->get('Version');
    $parent_style = 'base-style'; // This is the style name in Oren 

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 
    	'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        $themeVersion
    );
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );




//.......................................................................................................
// Custom Recommendation Taxonomy
//.......................................................................................................


// Create a custom Taxonomy called Recommendation
function recommendation_taxonomy() {
    
    $labels = array(
        'name' => _x( 'Recommendations', 'taxonomy general name' ),
        'singular_name' => _x('Recommendation', 'taxonomy singular name'),
        'search_items' => __('Search Feature'),
        'popular_items' => __('Common Recommendations'),
        'all_items' => __('All Recommendations'),
        'edit_item' => __('Edit Recommendation'),
        'update_item' => __('Update Recommendation'),
        'add_new_item' => __('Add new Recommendation'),
        'new_item_name' => __('New Recommendation:'),
        'add_or_remove_items' => __('Remove Recommendation'),
        'choose_from_most_used' => __('Choose from common Recommendation'),
        'not_found' => __('No Recommendation found.'),
        'menu_name' => __('Recommendations'),
    );

    $args = array(
        'public' => true,
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
    );

    register_taxonomy('recommendation', array('people'), $args);
}

add_action('init', 'recommendation_taxonomy');


function display_new_recommendation_meta () {
    ?>
    <div class="form-field">
        <label>
            <?php _e( 'Book Title' ); ?>
        </label>
        <input type="text" name="recommendation_book_title" id="recommendation_book_title" value="">
        <p class="description"><?php _e( 'Enter the slug title of the recommended Book. 
        Normal titles will be automatically slugified' ); ?></p>
    </div>
    <div class="form-field">
        <label>
            <?php _e( 'Sources Titles' ); ?>
        </label>
        <input type="text" name="recommendation_sources_titles" id="recommendation_sources_titles" value="">
        <p class="description"><?php _e( 'Enter the titles of the recommendation sources, with ; separators' ); ?></p>
    </div>
    <div class="form-field">
        <label>
            <?php _e( 'Sources URLs' ); ?>
        </label>
        <input type="text" name="recommendation_sources_urls" id="recommendation_sources_urls" value="">
        <p class="description"><?php _e( 'Enter the URLs to the recommendation sources, with ; separators and no spaces' ); ?></p>
    </div>
    <?php
}

add_action( 'recommendation_add_form_fields', 'display_new_recommendation_meta', 10, 2 );


function display_edit_recommendation_meta ($recommendation) {
    
    // Retrieve the Recommendation ID
    $recommendation_id = $recommendation->term_id;
 
    // Retrieve the existing meta value
    $recommendation_book_title = get_term_meta( $recommendation_id, 'book_title', true );
    $recommendation_sources_titles = get_term_meta( $recommendation_id, 'sources_titles', true );
    $recommendation_sources_urls = get_term_meta( $recommendation_id, 'sources_urls', true );
    ?>
    
    
    <tr class="form-field">
        <th scope="row" valign="top">
            <label>
                <?php _e( 'Book Title' ); ?>
            </label>
        </th>
        <td>
            <input type="text" name="recommendation_book_title" id="recommendation_book_title" value="<?php echo $recommendation_book_title ?>">
            <p class="description"><?php _e( 'Enter the slug title of the recommended Book. Normal titles will be automatically slugified' ); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label>
                <?php _e( 'Sources Titles' ); ?>
            </label>
        </th>
        <td>
            <input type="text" name="recommendation_sources_titles" id="recommendation_sources_titles" value="<?php echo $recommendation_sources_titles ?>">
            <p class="description"><?php _e( 'Enter the titles of the recommendation sources, with ; separators' ); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label>
                <?php _e( 'Sources URLs' ); ?>
            </label>
        </th>
        <td>
            <input type="text" name="recommendation_sources_urls" id="recommendation_sources_urls" value="<?php echo $recommendation_sources_urls ?>">
            <p class="description"><?php _e( 'Enter the URLs to the recommendation sources, with ; separators and no spaces' ); ?></p>
        </td>
    </tr>
    <?php
}

add_action( 'recommendation_edit_form_fields', 'display_edit_recommendation_meta', 10, 2 );


function recommendation_save_meta ( $recommendation_id, $recommendation ) {
    
    // Retrieve the existing meta value
    $recommendation_book_title = get_term_meta( $recommendation_id, 'book_title', true );
    $recommendation_sources_titles = get_term_meta( $recommendation_id, 'sources_titles', true );
    $recommendation_sources_urls = get_term_meta( $recommendation_id, 'sources_urls', true );
    
    // Store needed data in the post meta table
    if ( isset ( $_POST['recommendation_book_title']) && $_POST['recommendation_book_title'] != '' ) {
            $recommendation_book_title = $_POST['recommendation_book_title'];
        }
    if ( isset ( $_POST['recommendation_sources_titles']) && $_POST['recommendation_sources_titles'] != '' ) {
            $recommendation_sources_titles = $_POST['recommendation_sources_titles'];
        }
    if ( isset ( $_POST['recommendation_sources_urls']) && $_POST['recommendation_sources_urls'] != '' ) {
            $recommendation_sources_urls = $_POST['recommendation_sources_urls'];
        }


    // Save the new value
    update_term_meta( $recommendation_id, 'book_title', sanitize_title($recommendation_book_title) );
    update_term_meta( $recommendation_id, 'sources_titles', $recommendation_sources_titles );
    update_term_meta( $recommendation_id, 'sources_urls', $recommendation_sources_urls );
}  

add_action( 'edited_recommendation', 'recommendation_save_meta', 10, 2 );  
add_action( 'created_recommendation', 'recommendation_save_meta', 10, 2 );




//.......................................................................................................
// Custom Person and Book Post Types
//.......................................................................................................


// Create a custom post type for Person
function person_cpt() {

    register_post_type('person',
        
        array(

            'labels' => array(

                // The plural name
                'name' => __( 'Personnes' ),
                // The singular name
                'singular_name' => __( 'Personne' ),
                // The Wp-Admin menu text for creating a new CPT
                'add_new' => __('Add New Person'),
                // the Wp-Admin text when creating a new CPT
                'add_new_item' => __('Create a new Person'),   
                // The message when searching
                'search_items' => __( 'Look for a Person' ), 
                // The message after failed search
                'not_found' => __( 'Person not found' )
                ),
        
            // Public status implies certain functionalities. Keep at true
            'public' => true,

            // Hierarchical posts have parent/child abilities
            'hierarchical' => false,

            // Enables the archives
            'has_archive' => true,

            // Main fields 
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'page-attributes'
                ),

            // Declares the taxonomies that can be used on the CPT
            'taxonomies' => array(
                'category',
                'post_tag',
                'recommendation'
                ),

            // Makes sure we can query by index.php?person={person_slug_name}
            'publicly_queryable' => true,
            'query_var'          => true,
        )

    ); 

    // The rewrite rule that will translate the custom Permalink into a WP_Query
    add_rewrite_rule(
        '[^/]+/livres-recommandes/([^/]+)/?$',
        'index.php?person=$matches[1]',
        'top'
    );
}

add_action( 'init', 'person_cpt' );


// Create a custom post type for Book
function book_cpt() {
    register_post_type('book',
        
        array(

            'labels' => array(

                // The plural name
                'name' => __( 'Books' ),
                // The singular name
                'singular_name' => __( 'Book' ),
                // The Wp-Admin menu text for creating a new CPT
                'add_new' => __('Add New Book'),
                // The Wp-Admin text when creating a new CPT
                'add_new_item' => __('Create a new Book'),   
                // The message when searching
                'search_items' => __( 'Look for a Book' ), 
                // The message after failed search
                'not_found' => __( 'Book not found' )
                ),
        
            // Public status implies certain functionalities. Keep at true
            'public' => true,

            // Hierarchical posts have parent/child abilities
            'hierarchical' => false,

            // Enables the archives
            'has_archive' => true,

            // Main fields 
            'supports' => array(
                'title',
                'thumbnail',
                'page-attributes',
                ),

            // Declares the taxonomies that can be used on the CPT
            'taxonomies' => array(
                'post_tag',
                ),
            
            // Makes sure we can query by index.php?book={person_slug_name}
            'publicly_queryable' => true,
            'query_var'          => true,
        )

    );

    // The rewrite rule that will translate the custom Permalink into a WP_Query
    add_rewrite_rule(
        '^livres/([^/]+)/?$',
        'index.php?book=$matches[1]',
        'top'
    );
}

add_action( 'init', 'book_cpt' );


// Add Meta Fields for the Person and Book pages on Wp-Admin
add_action("admin_init", "my_admin");

function my_admin(){
    
    // Person meta box
    add_meta_box(
        "person_meta_box", 
        "Person Details", 
        "display_person_meta_fields", 
        "person", 
        "normal", 
        "high");

    // Book meta box
    add_meta_box(
        "book_meta_box", 
        "Book Details", 
        "display_book_meta_fields", 
        "book", 
        "normal", 
        "high");
}

function display_person_meta_fields( $person_page ) {

    // Retrieve the person page ID 
    $person_id = $person_page->ID;

    // Retrieve the meta variables
    $person_intro = esc_html( get_post_meta( $person_id, 'introduction', true ) );
    
    // HTML structure of the meta box
    ?>
    <table>
        <tr>
            <td style="width: 100%">Introduction Text</td>
            <td><input type="text" size="80" name="person_introduction" value="<?php echo $person_intro; ?>" /></td>
        </tr>
    </table>
    <?php
}


add_action( 'save_post', 'add_person_meta_fields', 10, 2 );

function add_person_meta_fields( $person_id, $person_page ) {
    
    // Make sure it is a Person page
    if( $person_page->post_type == 'person') {

        // Store needed data in the post meta table
        if ( isset( $_POST['person_introduction'] ) && $_POST['person_introduction'] != '' ) {
        update_post_meta( $person_id, 'introduction', $_POST['person_introduction'] );
        }
    }
}

function display_book_meta_fields( $book_page ) {

    // Retrieve the person page ID 
    $book_id = $book_page->ID;

    // Retrieve the meta variables  
    $book_author = esc_html( get_post_meta( $book_id, 'author', true ) );
    $book_summary = esc_html( get_post_meta( $book_id, 'summary', true ) );
    $book_genre = esc_html( get_post_meta( $book_id, 'genre', true ) );
    $book_theme = esc_html( get_post_meta( $book_id, 'theme', true ) );
    $book_rewards = esc_html( get_post_meta( $book_id, 'rewards', true ) );

    $book_leslibraires_url = esc_html( get_post_meta( $book_id, 'leslibraires_url', true ) );
    $book_amazon_url = esc_html( get_post_meta( $book_id, 'amazon_url', true ) );
    $book_fnac_url = esc_html( get_post_meta( $book_id, 'fnac_url', true ) );
    $book_priceminister_url = esc_html( get_post_meta( $book_id, 'priceminister_url', true ) );
    $book_recyclivre_url = esc_html( get_post_meta( $book_id, 'recyclivre_url', true ) );
    $book_ebook_url = esc_html( get_post_meta( $book_id, 'ebook_url', true ) );
    $book_gutenberg_url = esc_html( get_post_meta( $book_id, 'gutenberg_url', true ) );

    // HTML structure of the meta box
    ?>
    <table>
        <tr>
            <td style="width: 100%">Author</td>
            <td><input type="text" size="80" name="book_author" value="<?php echo $book_author; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Genre</td>
            <td><input type="text" size="80" name="book_genre" value="<?php echo $book_genre; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Theme</td>
            <td><input type="text" size="80" name="book_theme" value="<?php echo $book_theme; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Rewards</td>
            <td><input type="text" size="80" name="book_rewards" value="<?php echo $book_rewards; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Summary</td>
            <td><textarea rows="12" cols="80" name="book_summary"><?php echo $book_summary; ?></textarea></td>
        </tr>
        <tr>
            <td style="width: 100%">Les Libraires</td>
            <td><input type="text" size="80" name="book_leslibraires_url" value="<?php echo $book_leslibraires_url; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Amazon</td>
            <td><input type="text" size="80" name="book_amazon_url" value="<?php echo $book_amazon_url; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Fnac</td>
            <td><input type="text" size="80" name="book_fnac_url" value="<?php echo $book_fnac_url; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Price Minister</td>
            <td><input type="text" size="80" name="book_priceminister_url" value="<?php echo $book_priceminister_url; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Recyclivre</td>
            <td><input type="text" size="80" name="book_recyclivre_url" value="<?php echo $book_recyclivre_url; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">EBooks</td>
            <td><input type="text" size="80" name="book_ebook_url" value="<?php echo $book_ebook_url; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Gutenberg Project</td>
            <td><input type="text" size="80" name="book_gutenberg_url" value="<?php echo $book_gutenberg_url; ?>" /></td>
        </tr>
    </table>
    <?php
}


add_action( 'save_post', 'add_book_meta_fields', 10, 2 );

function add_book_meta_fields( $book_id, $book_page ) {
    
    // Make sure it is a Book page
    if( $book_page->post_type == 'book') {

        // Store needed data in the post meta table

        if ( isset( $_POST['book_author'] ) && $_POST['book_author'] != '' ) {
        update_post_meta( $book_id, 'author', $_POST['book_author'] );
        }
        if ( isset( $_POST['book_summary'] ) && $_POST['book_summary'] != '' ) {
        update_post_meta( $book_id, 'summary', $_POST['book_summary'] );
        }
        if ( isset( $_POST['book_genre'] ) && $_POST['book_genre'] != '' ) {
        update_post_meta( $book_id, 'genre', $_POST['book_genre'] );
        }
        if ( isset( $_POST['book_theme'] ) && $_POST['book_theme'] != '' ) {
        update_post_meta( $book_id, 'theme', $_POST['book_theme'] );
        }
        if ( isset( $_POST['book_rewards'] ) && $_POST['book_rewards'] != '' ) {
        update_post_meta( $book_id, 'rewards', $_POST['book_rewards'] );
        }

        if ( isset( $_POST['book_leslibraires_url'] ) && $_POST['book_leslibraires_url'] != '' ) {
        update_post_meta( $book_id, 'leslibraires_url', $_POST['book_leslibraires_url'] );
        }
        if ( isset( $_POST['book_amazon_url'] ) && $_POST['book_amazon_url'] != '' ) {
        update_post_meta( $book_id, 'amazon_url', $_POST['book_amazon_url'] );
        }
        if ( isset( $_POST['book_fnac_url'] ) && $_POST['book_fnac_url'] != '' ) {
        update_post_meta( $book_id, 'fnac_url', $_POST['book_fnac_url'] );
        }
        if ( isset( $_POST['book_priceminister_url'] ) && $_POST['book_priceminister_url'] != '' ) {
        update_post_meta( $book_id, 'priceminister_url', $_POST['book_priceminister_url'] );
        }
        if ( isset( $_POST['book_recyclivre_url'] ) && $_POST['book_recyclivre_url'] != '' ) {
        update_post_meta( $book_id, 'recyclivre_url', $_POST['book_recyclivre_url'] );
        }
        if ( isset( $_POST['book_ebook_url'] ) && $_POST['book_ebook_url'] != '' ) {
        update_post_meta( $book_id, 'ebook_url', $_POST['book_ebook_url'] );
        }
        if ( isset( $_POST['book_gutenberg_url'] ) && $_POST['book_gutenberg_url'] != '' ) {
        update_post_meta( $book_id, 'gutenberg_url', $_POST['book_gutenberg_url'] );
        }
    }
}




//.......................................................................................................
// Custom Permalinks : Person, Book 
//.......................................................................................................


add_filter( 'post_type_link', 'custom_permalinks', 10, 4 );

function custom_permalinks( $permalink, $post, $leavename, $sample ) {

    // Permalinks for Person post types
    if ( $post->post_type == 'person' && get_option( 'permalink_structure' ) ) {

        $struct = '/%category%/livres-recommandes/%postname%/';

        $rewritecodes = array(
            '%category%',
            '%postname%'
        );

        $category = '';
        $cats = get_the_terms( $post->ID , 'category' );

        if ( $cats ) {
            usort($cats, '_usort_terms_by_ID'); // order by ID
            $category = $cats[0]->slug;
            if ( $parent = $cats[0]->parent ) {
                $category = get_category_parents($parent, false, '/', true) . $category;
            }
        }

        if ( empty($category) ) {
            $category = 'pas-de-categorie';
        }

        $replacements = array(
            $category,
            $post->post_name
        );

        $permalink = home_url( str_replace( $rewritecodes, $replacements, $struct ) );
    }
    
    // Permalinks for Book post types
    elseif ( $post->post_type == 'book' && get_option( 'permalink_structure' ) ) {

        $struct = '/livres/%postname%/';

        $rewritecodes = array(
            '%postname%'
        );

        $replacements = array(
            $post->post_name
        );

        $permalink = home_url( str_replace( $rewritecodes, $replacements, $struct ) );
    }

    return $permalink;
}




//.......................................................................................................
// Custom Permalinks : Search Results
//.......................................................................................................


add_action( 'template_redirect', 'search_url_redirect_url' );

function search_url_redirect_url() {
    if ( is_search() && ! empty( $_GET['s'] ) ) {
        wp_redirect( home_url( "/recherche/" ) . urlencode( get_query_var( 's' ) ) );
        exit();
    }   
}


add_action( 'init', 'search_url_rewrite_url' );

function search_url_rewrite_url() {
    add_rewrite_rule(
            '^recherche/([^/]+)/?$',
            'index.php?s=$matches[1]',
            'top'
        );
}




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




//.......................................................................................................
// Homepage : gathering array of names and sentences for typing cursor JS effect 
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




?>