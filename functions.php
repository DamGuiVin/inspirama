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

?>
