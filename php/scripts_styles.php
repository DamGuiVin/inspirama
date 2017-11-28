<?php 

//.......................................................................................................
// Enqueueing Scripts and Styles
//.......................................................................................................

function inspirama_enqueue_scripts() {

    // We need to append the version to the scripts so that 
    // the user cache gets refreshed if any change happened 
    $themeVersion = wp_get_theme()->get('Version');

    wp_register_script( 'inspirama_previewer', get_stylesheet_directory_uri() . '/js/previewer.min.js', array('jquery'), $themeVersion, true );
    wp_register_script( 'inspirama_typed', get_stylesheet_directory_uri() . '/js/typed.min.js', array('jquery'), $themeVersion, true );
    wp_register_script( 'inspirama_smooth_scroll', get_stylesheet_directory_uri() . '/js/smooth_scroll.min.js', array('jquery'), $themeVersion, true);
    wp_register_script( 'inspirama_ajax', get_stylesheet_directory_uri() . '/js/ajax.js', array('jquery'), $themeVersion, true);

    // Homepage only : typed.js and smooth_scroll.js
    if( is_front_page() ){
        wp_enqueue_script('inspirama_typed');
        $list_names_php = get_all_people_names();
        wp_localize_script( 'inspirama_typed', 'list_names', $list_names_php );

        wp_enqueue_script('inspirama_ajax');
        wp_localize_script( 'inspirama_ajax', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );

        //wp_enqueue_script('inspirama_smooth_scroll');
    }

    // Person only : previewer.js
    if( is_singular('person') ){
        wp_enqueue_script( 'inspirama_previewer' );
    }
}

add_action( 'wp_enqueue_scripts', 'inspirama_enqueue_scripts' );



function inspirama_enqueue_styles() {

    // This enqueues the parent theme's style.css before the child's (faster than using @import in our style.css)
    $themeVersion = wp_get_theme()->get('Version');
    $parent_style = 'base-style'; // this is the stylesheet handle defined in Oren
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ), $themeVersion );

    wp_enqueue_style( 'inspirama_fonts', "https://fonts.googleapis.com/css?family=Amatic+SC|Arvo|Boogaloo|Cabin+Sketch|Crimson+Text|Kalam|Roboto+Condensed|Vidaloka" );
    wp_enqueue_style( 'inspirama_social_media_style', get_stylesheet_directory_uri() . '/css/social_media.css', array( 'child-style' ), $themeVersion );

    if( is_front_page() ){
        wp_enqueue_style( 'inspirama_carousels_style', get_stylesheet_directory_uri() . '/css/carousels.css', array( 'child-style' ), $themeVersion );
        wp_enqueue_style( 'inspirama_typed_style', get_stylesheet_directory_uri() . '/css/typed.css', array( 'child-style' ), $themeVersion );
    }
    
    if( is_singular('book') ){
        wp_enqueue_style( 'inspirama_book_style', get_stylesheet_directory_uri() . '/css/books.css', array( 'child-style' ), $themeVersion );
    }

    if( is_singular('person') ){
        wp_enqueue_style( 'inspirama_previewer_style', get_stylesheet_directory_uri() . '/css/people.css', array( 'child-style' ), $themeVersion );
        wp_enqueue_style( 'inspirama_previewer_style', get_stylesheet_directory_uri() . '/css/previewer.css', array( 'child-style' ), $themeVersion );
    }
}

add_action( 'wp_enqueue_scripts', 'inspirama_enqueue_styles' );



function inspirama_dequeue_useless_scripts() {

    // Custom is an Oren script for images and menu fade in. 
    // Slows down Homepage background loading
    //wp_dequeue_script( 'custom' );
    //wp_deregister_script( 'custom' );

    // Modernizer is to handle various browser versions
    wp_dequeue_script( 'modernizer' );
    wp_deregister_script( 'modernizer' );
    
    // Retina is to handle high resolution images
    wp_dequeue_script( 'retina' );
    wp_deregister_script( 'retina' );   

    // Embeds is to cleanly embed videos and images from URLs
    wp_dequeue_script( 'wp-embed' );
    wp_deregister_script( 'wp-embed' );

}

add_action( 'wp_print_scripts', 'inspirama_dequeue_useless_scripts' );



function inspirama_asychronous_deferred_scripts( $tag, $handle, $src ) {

    // Script optimization only if we are on the website and not the admin
    // Otherwise broken dependencies for admin plugins
    if ( ! is_user_logged_in() ) {

        // The handles of the enqueued scripts we want to async
        $async_scripts = array( 
            //'jquery-core', // We cannot async this because too risky for dependencies gotta find another solution
            //'jquery',
        );

        if ( in_array( $handle, $async_scripts ) ) {
            return '<script type="text/javascript" src="' . $src . '" async="async"></script>' . "\n";
        }

        // The handles of the enqueued scripts we want to defer
        $defer_scripts = array( 
            'jquery-migrate',
            'iss-suggest',
            'mustache',
            'iss',
            'admin-bar',
            'debug-bar',
            'opinionstage-shortcodes',
            'inspirama_typed',
            'inspirama_smooth_scroll',
            'inspirama_previewer',
            'inspirama_ajax',
            'custom',
            'bootstrap',
            'underscore'
        );

        if ( in_array( $handle, $defer_scripts ) ) {
            return '<script type="text/javascript" src="' . $src . '" defer="defer"></script>' . "\n";
        }
    }

    return $tag;
}

add_filter( 'script_loader_tag', 'inspirama_asychronous_deferred_scripts', 10, 3  );



function inspirama_dequeue_useless_styles() {

    // These are styles loaded by Oren that we don't need
    wp_dequeue_style( 'fontAwesome' );
    wp_deregister_style( 'fontAwesome' );

    wp_dequeue_style( 'themeora-fontAwesome' );
    wp_deregister_style( 'themeora-fontAwesome' );

    wp_dequeue_style( 'google-fonts' );
    wp_deregister_style( 'google-fonts' );
}

add_action( 'wp_print_styles', 'inspirama_dequeue_useless_styles' );


?>