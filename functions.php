<?php

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



// Custom permalink structure for PAGES in wordpress
// BUT THERE IS PROBLEM: 
//		By default, Oren uses Pages instead of Posts
// 		but Pages do not have Categories nor Tags in default WP
//		so we use a plugin to add them. But does not seem to work here
//		as the $wp_rewrite->category_structure should return the category name
//		for Posts, but does not seem to work here
//		https://codex.wordpress.org/Class_Reference/WP_Rewrite
// custom_page_rules() {
//    global $wp_rewrite;
//    $wp_rewrite->page_structure = $wp_rewrite->root . $wp_rewrite->category_structure . '/%pagename%/';
//}
//add_action( 'init', 'custom_page_rules' );





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

    register_taxonomy('recommendation', array('books', 'people'), $args);
}

add_action('init', 'recommendation_taxonomy');



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

                //'' => __( '' )
                ),
        
            // Public status implies certain functionalities. Keep at true
            'public' => true,

            // Hierarchical posts have parent/child abilities (Pages butnot Posts)
            'hierarchical' => true,

            // Enables the archives
            'has_archive' => true,

            // Main fields 
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'page-attributes',
                ),

            // Declares the taxonomies that can be used on the CPT
            'taxonomies' => array(
                'category',
                'post_tag',
                'recommendation'
                ),
        )

  );
}

add_action( 'init', 'person_cpt' );



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
    $book_momox_url = esc_html( get_post_meta( $book_id, 'momox_url', true ) );
    $book_recyclivre_url = esc_html( get_post_meta( $book_id, 'recyclivre_url', true ) );
    $book_koober_url = esc_html( get_post_meta( $book_id, 'koober_url', true ) );
    $book_audible_url = esc_html( get_post_meta( $book_id, 'audible_url', true ) );
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
            <td style="width: 100%">Summary</td>
            <td><textarea rows="6" cols="80" name="book_summary"><?php echo $book_summary; ?></textarea></td>
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
            <td style="width: 100%">Momox</td>
            <td><input type="text" size="80" name="book_momox_url" value="<?php echo $book_momox_url; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Recyclivre</td>
            <td><input type="text" size="80" name="book_recyclivre_url" value="<?php echo $book_recyclivre_url; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Koober</td>
            <td><input type="text" size="80" name="book_koober_url" value="<?php echo $book_koober_url; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Audible</td>
            <td><input type="text" size="80" name="book_audible_url" value="<?php echo $book_audible_url; ?>" /></td>
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
        if ( isset( $_POST['book_momox_url'] ) && $_POST['book_momox_url'] != '' ) {
        update_post_meta( $book_id, 'momox_url', $_POST['book_momox_url'] );
        }
        if ( isset( $_POST['book_recyclivre_url'] ) && $_POST['book_recyclivre_url'] != '' ) {
        update_post_meta( $book_id, 'recyclivre_url', $_POST['book_recyclivre_url'] );
        }
        if ( isset( $_POST['book_koober_url'] ) && $_POST['book_koober_url'] != '' ) {
        update_post_meta( $book_id, 'koober_url', $_POST['book_koober_url'] );
        }
        if ( isset( $_POST['book_audible_url'] ) && $_POST['book_audible_url'] != '' ) {
        update_post_meta( $book_id, 'audible_url', $_POST['book_audible_url'] );
        }
        if ( isset( $_POST['book_ebook_url'] ) && $_POST['book_ebook_url'] != '' ) {
        update_post_meta( $book_id, 'ebook_url', $_POST['book_ebook_url'] );
        }
        if ( isset( $_POST['book_gutenberg_url'] ) && $_POST['book_gutenberg_url'] != '' ) {
        update_post_meta( $book_id, 'gutenberg_url', $_POST['book_gutenberg_url'] );
        }
    }
}



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


                //'' => __( '' )
                ),
        
            // Public status implies certain functionalities. Keep at true
            'public' => true,

            // Hierarchical posts have parent/child abilities (Pages butnot Posts)
            'hierarchical' => true,

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
                'category',
                'post_tag',
                'recommendation'
                ),
        )

  );
}

add_action( 'init', 'book_cpt' );










?>
