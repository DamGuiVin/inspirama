<?php 


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
// Custom Permalinks : Category pages
//.......................................................................................................

add_filter( 'term_link', 'custom_category_permalink', 10, 1 );

function custom_category_permalink( $termlink ){ 
    return str_replace('/./', '/', $termlink);
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

?>