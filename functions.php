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
// Custom Permalinks
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




/*

//.......................................................................................................
// ONE-TIME SCRIPT
//.......................................................................................................

if ( isset($_GET['run_my_script']) && ! get_option('my_script_complete') ) {
    add_action('init', 'my_script_function', 10);
    add_action('init', 'script_finished', 20);
}
 
function my_script_function() {
    
    //$file = fopen("contacts.csv","r");
    //print_r(fgetcsv($file));
    //fclose($file);



    $recommendation_id = wp_insert_term(
        'PEW pew PEW', // the term 
        'recommendation', // the taxonomy
        array(
            'description'=>"Zbrrraaa! Ca c'est une recomandation qui dechire"
        )
    );

    //$recommendation_id = $ids_array['term_id'];
    if($recommendation_id) {
        update_term_meta( $recommendation_id, 'book_title', sanitize_title("Le livre de Mes reves") );
        update_term_meta( $recommendation_id, 'sources_titles', "Telerama" );
        update_term_meta( $recommendation_id, 'sources_urls', "www.champion.fr" );
    };




    $person_id = wp_insert_post(array (
        'post_type' => 'person',
        'post_title' => "Une Personne Ajoutee Automatiquement",
        'post_content' => "Biographie de la personne, un texte long et <strong>ennuyeux</strong>!",
        'post_status' => 'publish',
    ));

    if ($person_id) {
        update_post_meta( $person_id, 'intro', "Texte introductif, grosse punchline de preference" );
    };




    $book_id = wp_insert_post(array (
        'post_type' => 'book',
        'post_title' => "Un Bouquin Ajoute Automatiquement",
        'post_status' => 'publish',
    ));

    if ($book_id) {
        add_post_meta($book_id, '', '');

        update_post_meta( $book_id, 'author', "Conan Doyle" );
        update_post_meta( $book_id, 'summary', "C'est l'histoire d'un mec..." );
        update_post_meta( $book_id, 'genre', "Poesie romantique" );
        update_post_meta( $book_id, 'theme', "Vampires et Tuning" );
        update_post_meta( $book_id, 'rewards', "Pulitzer 2017" );
        update_post_meta( $book_id, 'leslibraires_url', "www.example.com" );
        update_post_meta( $book_id, 'amazon_url', "www.example.com" );
        update_post_meta( $book_id, 'fnac_url', "www.example.com" );
        update_post_meta( $book_id, 'priceminister_url', "www.example.com" );
        update_post_meta( $book_id, 'recyclivre_url', "www.example.com" );
        update_post_meta( $book_id, 'ebook_url', "www.example.com" );
        update_post_meta( $book_id, 'gutenberg_url', "www.example.com" );
    };
}


function script_finished() {
    //add_option('my_script_complete', 1);
    die("Script finished.");
}

*/

?>