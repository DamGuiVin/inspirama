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


<!-- Top Recommendations Carousel -->
<?php recommendations_carousel( array(  
    'les-freres-karamazov', 
    'le-cycle-de-fondation-tome-2-fondation-et-empire',
    'vagabonding',
    'le-petit-prince') ); ?>


<!-- Top Books Section -->
<div class="container-fluid">
    <div class="row">
        <div class="WAZAAAAA">
            
            <h2>Les livres recommandés par les 
                <div id="books-carousel-people-categories" class="dropdown books-carousel-people-categories">
                    <button class="btn btn-basic dropdown-toggle" type="button" data-toggle="dropdown">
                        ______<span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#books-carousel-people-categories">Entrepreneurs</a></li>
                        <li><a href="#books-carousel-people-categories">Artistes</a></li>
                        <li><a href="#books-carousel-people-categories">Politiciens</a></li>
                        <li><a href="#books-carousel-people-categories">Autres</a></li>
                    </ul>
                </div>
            </h2>

            <?php books_carousel(); ?>

        </div>
    </div>
</div>


<?php
//........................................................................
// FOOTER SECTION 
//........................................................................

get_footer(); ?>