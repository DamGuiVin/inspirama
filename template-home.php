<?php

/*

* Template Name: Home

*/



//........................................................................
// HEADER SECTION
//........................................................................

get_header();



//........................................................................
// HOMEPAGE PRESENTATION SECTION
//........................................................................

// Get the homepage's background image. Use header_image if set, featured image if not
$background_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full-size' )[0]; 

?>


<!-- Homepage Presentation -->
<header style="background: url(<?php echo $background_image; ?>); background-position: center top; background-size: cover; background-attachment: fixed;" class="full-width-container-home welcome-screen" role="banner">

    <!-- Homepage welcome Text -->
    <div class="welcome-container-home">
        <?php while ( have_posts() ) : the_post(); ?>
            <h1 id="typing-title" class="one-line-ellipsis">
                <?php the_title(); ?><span class="element"></span><span class="typed-cursor"></span>
            </h1>
        <?php endwhile; ?>
    </div>

</header>



<?php 
//........................................................................
// CAROUSELS SECTION
//........................................................................

    $args['books_slugs_array'] = array(  
        'les-freres-karamazov', 
        'le-cycle-de-fondation-tome-2-fondation-et-empire',
        'vagabonding',
        'le-petit-prince');

    inspirama_carousel_wrapper( 
        $carousel_title = 'Carroussel de recommandations',
        array(),
        $carousel_type = 'recommendations',
        $args);
    
    inspirama_carousel_wrapper( 
        $carousel_title = 'Carroussel de livres',
        array('Artistes', 'Entrepreneurs', 'Politiciens', 'Autres'),
        $carousel_type = 'books');



//........................................................................
// FOOTER SECTION 
//........................................................................

get_footer(); ?>