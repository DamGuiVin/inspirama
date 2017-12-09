<?php


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
// Inspirama Custom Taxonomies : Declaration
//.......................................................................................................

// Job taxonomy for People (Category type)
add_action('init', 'job_taxonomy');

function job_taxonomy() {
    
    $labels = array(
        'name' => _x( 'Fonction', 'taxonomy general name' ),
        'singular_name' => _x('Fonction', 'taxonomy singular name'),
        'search_items' => __('Chercher une Fonction'),
        'all_items' => __('Toutes les Fonctions'),
        'edit_item' => __('Modifier la Fonction'),
        'update_item' => __('Mettre à jour la Fonction'),
        'add_new_item' => __('Ajouter une nouvelle Fonction'),
        'new_item_name' => __('Nouvelle Fonction:'),
        'add_or_remove_items' => __('Supprimer la Fonction'),
        'not_found' => __('Fonction introuvable.')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'hierarchical' => true,
        'show_ui' => true
    );

    register_taxonomy('person_job', array('person'), $args);
}



// Genre taxonomy for Books (Category type)
add_action('init', 'genre_taxonomy');

function genre_taxonomy() {
    
    $labels = array(
        'name' => _x( 'Genre', 'taxonomy general name' ),
        'singular_name' => _x('Genre', 'taxonomy singular name'),
        'search_items' => __('Chercher un Genre'),
        'all_items' => __('Tous les Genres'),
        'edit_item' => __('Modifier le Genre'),
        'update_item' => __('Mettre à jour le Genre'),
        'add_new_item' => __('Ajouter un nouveau Genre'),
        'new_item_name' => __('Nouveau Genre:'),
        'add_or_remove_items' => __('Supprimer le Genre'),
        'not_found' => __('Genre introuvable.')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'hierarchical' => true,
        'show_ui' => true
    );

    register_taxonomy('book_genre', array('book'), $args);
}




//.......................................................................................................
// Inspirama Custom Post Types : Declaration
//.......................................................................................................

// Person CPT
add_action( 'init', 'person_cpt' );

function person_cpt() {

    register_post_type('person', array(

        'labels' => array(
            'name' => __( 'Personnes' ),
            'singular_name' => __( 'Personne' ),
            'add_new' => __('Ajouter une nouvele Personne'),
            'add_new_item' => __('Créer une nouvelle Personne'), 
            'search_items' => __( 'Chercher une Personne' ), 
            'not_found' => __( 'Personne introuvable' )
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
            'thumbnail' ),

        // Declares the taxonomies that can be used on the CPT
        'taxonomies' => array(
            'category',
            'recommendation' ),

        // Makes sure we can query by index.php?person={person_slug_name}
        'publicly_queryable' => true,
        'query_var'          => true )

    ); 

    // The rewrite rule that will translate the custom Permalink into a WP_Query
    add_rewrite_rule(
        '[^/]+/livres-recommandes/([^/]+)/?$',
        'index.php?person=$matches[1]',
        'top'
    );
}


// Book CPT
add_action( 'init', 'book_cpt' );

function book_cpt() {

    register_post_type('book', array(

        'labels' => array(
            'name' => __( 'Livres' ),
            'singular_name' => __( 'Livre' ),
            'add_new' => __('Ajouter un Livre'),
            'add_new_item' => __('Créer un nouveau Livre'), 
            'search_items' => __( 'Chercher un Livre' ), 
            'not_found' => __( 'Livre introuvable' )
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
            'thumbnail' ),

        // Declares the taxonomies that can be used on the CPT
        'taxonomies' => array(),
        
        // Makes sure we can query by index.php?book={book_slug_name}
        'publicly_queryable' => true,
        'query_var'          => true )
    );

    // The rewrite rule that will translate the custom Permalink into a WP_Query
    add_rewrite_rule(
        '^livres/([^/]+)/?$',
        'index.php?book=$matches[1]',
        'top'
    );
}


// Recommendation CPT
add_action( 'init', 'recommendation_cpt' );

function recommendation_cpt() {

    register_post_type('recommendation', array(

        'labels' => array(
            'name' => __( 'Recommandations' ),
            'singular_name' => __( 'Recommandations' ),
            'add_new' => __('Ajouter une nouvelle Recommandation'),
            'add_new_item' => __('Créer une nouvelle Recommandation'), 
            'search_items' => __( 'Chercher une Recommandation' ), 
            'not_found' => __( 'Recommandation introuvable' )
            ),

        // We don't want permalinks to go to a recommendation page (no public query)
        // we only want to be able to edit it on the Admin 
        // and to query the necessary data in php (private query)
        'public' => false,
        'show_in_nav_menus' => true, 
        'show_ui' => true,

        // Enables the archives
        'has_archive' => false,

        // Main fields 
        'supports' => array(
            'title',
            'editor' ) )
    ); 
}



//.......................................................................................................
// Inspirama Custom Post Types : Meta Fields
//.......................................................................................................

// Add Meta Fields for the Custom Post Types on the Admin
add_action("admin_init", "inspirama_admin");

function inspirama_admin(){
    
    // Person meta box
    add_meta_box(
        "person_meta_box", 
        "Détails de la Personne", 
        "display_cpt_meta_fields", 
        "person", 
        "normal", 
        "high");

    // Book meta box
    add_meta_box(
        "book_meta_box", 
        "Détails du Livre", 
        "display_cpt_meta_fields", 
        "book", 
        "normal", 
        "high");

    // Recommendation meta box
    add_meta_box(
        "recommendation_meta_box", 
        "Détails de la Recommandation", 
        "display_recommendation_meta_fields", 
        "recommendation", 
        "normal", 
        "high");
}


// Meta fields declaration function for Book and Person 
// (different from Recommendation CPT because don't need dropdowns on content data)
function display_cpt_meta_fields( $cpt_page ) {

    // Retrieve the cpt page ID 
    $cpt_id = $cpt_page->ID;
    $cpt_meta_data = [];
    $key = [];
    $prefix = '';

    if( $cpt_page->post_type == 'book') {
        $prefix = 'book';
        $keys = array(
            array( 'author', 'Auteur'),
            array( 'summary', 'Résumé'),
            array( 'genre', 'Genre'),
            array( 'theme', 'Thème'),
            array( 'rewards', 'Prix Littéraires'),
            array( 'leslibraires_url', 'URL Les Libraires'),
            array( 'amazon_url', 'URL Amazon'),
            array( 'fnac_url', 'URL Fnac'),
            array( 'priceminister_url', 'URL Price Minister'),
            array( 'recyclivre_url', 'URL Recyclivre'),
            array( 'ebooks_url', 'URL eBooks'),
            array( 'gutenberg_url', 'URL Gutenberg Project') );
    }

    elseif ( $cpt_page->post_type == 'person' ) {
        $prefix = 'person';
        $keys = array(
            array( 'introduction', 'Phrase d\'introduction') );
    }

    // HTML structure of the meta box
    ?>
    <table>
        <?php foreach( $keys as $key ) : 
            $cpt_meta_datum = esc_html( get_post_meta( $cpt_id, $key[0], true ) ); ?>
            <tr>
                <td style="width: 100%"><?php echo $key[1]; ?></td>
                <td><input type="text" size="80" name="<?php echo $prefix . '_' . $key[0]; ?>" value="<?php echo $cpt_meta_datum; ?>" /></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
}


// Meta fields declaration function for Recommendation
function display_recommendation_meta_fields( $recommendation_page ) {
 
    $people = get_all_names_and_ids_by_cpt( 'person' );
    $current_person_id = esc_html( get_post_meta( $recommendation_page->ID, 'recommendation_person_id', true ) );
    $current_person_name = $people[ $current_person_id ];

    $books = get_all_names_and_ids_by_cpt( 'book' );
    $current_book_id = esc_html( get_post_meta( $recommendation_page->ID, 'recommendation_book_id', true ) );
    $current_book_name = $books[ $current_book_id ];

    ?>
    <table>
        <tr>
            <td style="width: 100%">Recommandeur(euse)</td>
            <td>
                <select name="recommendation_person_id">
                    <?php foreach( $people as $id => $name ) : ?>
                        <option value="<?php echo $id; ?>" "<?php selected( $current_person_name, $name); ?>"><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td style="width: 100%">Livre recommandé</td>
            <td>
                <select name="recommendation_book_id">
                    <?php foreach( $books as $id => $name ) : ?>
                        <option value="<?php echo $id; ?>" "<?php selected( $current_book_name, $name); ?>"><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}


// Saving the CPT meta data for Book, Person and Recommendation
add_action( 'save_post', 'save_cpt_meta_fields', 10, 2 );

function save_cpt_meta_fields( $cpt_id, $cpt_page ) {
    
    $key = [];
    $prefix = '';

    if( $cpt_page->post_type == 'book') {
        $prefix = 'book';
        $keys = array(
            'author',
            'summary',
            'genre', 
            'theme',
            'rewards',
            'leslibraires_url',
            'amazon_url',
            'fnac_url',
            'priceminister_url',
            'recyclivre_url',
            'ebooks_url',
            'gutenberg_url' );
    }

    elseif ( $cpt_page->post_type == 'person' ) {
        $prefix = 'person';
        $keys = array(
            'introduction' );
    }

    elseif ( $cpt_page->post_type == 'recommendation' ) {
        $prefix = 'recommendation';
        $keys = array(
            'person_id',
            'book_id' );

        THIS IS NOT WORKING IT DOES NOT SAVE THE DATA FROM THE DROPDOWNS FOR RECOMMENDATIONS
    }

    foreach ( $keys as $key ) {
        $meta_field = $prefix . '_' . $key;
        if ( isset( $_POST[ $meta_field ] ) && $_POST[ $meta_field ] != '' ) {
            update_post_meta( $cpt_id, $key, $_POST[ $meta_field ] );
        }
    }
}



//.......................................................................................................
// Admin Post Management Screen : choose columns to display
//.......................................................................................................

// Manage columns for Recommendation post type
add_action('manage_recommendation_posts_columns','manage_columns_for_recommendation');

function manage_columns_for_recommendation( $columns ) {
    
    // Remove columns
    unset($columns['date']);
    unset($columns['comments']);
    unset($columns['author']);

    // Add new columns
    $columns['recommendation_person'] = 'Personne';
    $columns['recommendation_book'] = 'Livre'; 

    return $columns;
}

// Populate columns for Recommenation post type
add_action('manage_recommendation_posts_custom_column','populate_recommendation_columns',10,2);

function populate_recommendation_columns( $column, $post_id ) {

    // Person column
    if( $column == 'recommendation_person' ){ 
        $person_id = get_post_meta( $post_id, 'recommendation_person_id', true );
        $person_name = get_the_title( $person_id );

        if( $person_id && $person_name ){ echo $person_name; }
        else { echo '_';}
    }

    // Book column
    if( $column == 'recommendation_book' ){ 
        $book_id = get_post_meta( $post_id, 'recommendation_book_id', true );
        $book_name = get_the_title( $book_id );

        if( $book_id && $book_name ){ echo $book_name; }
        else { echo '_';}
    }
}



//.......................................................................................................
// Admin Menu : remove the Posts, Comments and Users links
//.......................................................................................................

add_action( 'admin_menu', 'inspirama_remove_admin_menu_items' );

function inspirama_remove_admin_menu_items() {
    remove_menu_page('edit.php');               // Posts
    remove_menu_page('edit-comments.php');      // Comments 
    remove_menu_page('users.php');              // Users
}




?>