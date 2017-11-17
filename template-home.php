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
?>

<!-- Homepage Presentation -->
<header class="full-width-container-home welcome-screen" role="banner">

    <!-- Homepage welcome Text -->
    <div class="welcome-container-home">
        <?php while ( have_posts() ) : the_post(); ?>
            <h1 id="typing-title" class="one-line-ellipsis">
                <?php the_title(); ?><span class="element"></span><span class="typed-cursor"></span>
            </h1>
        <?php endwhile; ?>
    </div>

</header>

<!-- Open text search bar -->
<div class="container-fluid homepage-open-search">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3">
            <?php get_search_form(); ?>
        </div>
    </div>
</div>



<?php 
//........................................................................
// CAROUSELS SECTION
//........................................................................

    $recommended_books['books_slugs_array'] = array(  
        'les-freres-karamazov', 
        'le-cycle-de-fondation-tome-2-fondation-et-empire',
        'vagabonding',
        'le-petit-prince');

    inspirama_carousel_wrapper( 
        $carousel_title = 'Les recommandations les plus populaires',
        array(),
        $carousel_type = 'recommendations',
        $recommended_books);
    
    inspirama_carousel_wrapper( 
        $carousel_title = 'Les livres recommandés par les',
        array('Artistes', 'Entrepreneurs', 'Politiciens', 'Autres'),
        $carousel_type = 'books');

    inspirama_carousel_wrapper( 
        $carousel_title = 'Les personnes les plus populaires',
        array(),
        $carousel_type = 'people');



//........................................................................
// FOOTER SECTION 
//........................................................................

get_footer(); ?>