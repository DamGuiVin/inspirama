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

    <header style="background: url(<?php echo $background_image; ?>); background-position: center top; background-size: cover;" class="full-width-container-home welcome-screen" role="banner">

        <!-- Homepage welcome Text -->
        <div class="welcome-container-home">
            <?php while ( have_posts() ) : the_post(); ?>
                <div id="bg">
                    <h1 class="title-homepage">
                        <?php the_title(); ?><span class="element"></span><span class="typed-cursor"></span>
                    </h1>
                </div>
            <?php endwhile; ?>

            <?php $top_recommendations = get_top_recommendations( array('les-freres-karamazov', 'le-cycle-de-fondation-tome-2-fondation-et-empire') ); ?>
            <?php if ( !empty( $top_recommendations )) : ?>

                <!-- Top Recommendations Carousel -->
                <div id="recommandations-populaires" class="carousel slide" data-ride="carousel" data-interval="8000">
                    
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#recommandations-populaires" data-slide-to="0" class="active"></li>
                        <?php for ( $i = 1; $i < count( $top_recommendations ); $i++ ) : ?>
                            <li data-target="#recommandations-populaires" data-slide-to="<?php echo $i; ?>"></li>
                        <?php endfor ?>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">

                        <?php foreach ( $top_recommendations as $i => $one_book_recommendations) : ?>
                            <?php if ( $i == 0 ) : ?>

                                <div class="item active">
                                    <div class="container">
                                        <div class="row">
                                            <div class="hp-recommendations col-xs-10 col-xs-offset-1">
                                                <div class="recommended-book col-xs-3">
                                                    <a href="<?php echo $one_book_recommendations['book_url']; ?>">
                                                        <img class="img-adapt" src="<?php echo $one_book_recommendations['book_image']; ?>">
                                                    </a>
                                                    <h3 class="one-line-ellipsis"><?php echo $one_book_recommendations['book_title']; ?></h3>
                                                    <h4 class="one-line-ellipsis"><?php echo $one_book_recommendations['book_author']; ?></h4>
                                                </div>
                                                <div class="list-recommendations col-xs-9">
                                                    <ul>
                                                        <?php foreach ( $one_book_recommendations['recommendations'] as $i => $one_person_recommendation ) : ?>
                                                            <?php if ( $i < 3 ) : ?>
                                                                <li>
                                                                    <div class="one-recommendation">
                                                                        <blockquote class="quote"><?php echo $one_person_recommendation['text']; ?></blockquote>
                                                                        <h3 class="one-line-ellipsis"><?php echo $one_person_recommendation['person_name']; ?></h3>
                                                                        <a href="<?php echo $one_person_recommendation['person_url']; ?>">
                                                                            <img class="img-adapt" src="<?php echo $one_person_recommendation['person_image']; ?>">
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                            <?php endif ?>
                                                        <?php endforeach ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php else : ?>

                                <div class="item">
                                    <div class="container">
                                        <div class="row">
                                            <div class="hp-recommendations col-xs-10 col-xs-offset-1">
                                                <div class="recommended-book col-xs-3">
                                                    <a href="<?php echo $one_book_recommendations['book_url']; ?>">
                                                        <img class="img-adapt" src="<?php echo $one_book_recommendations['book_image']; ?>">
                                                    </a>
                                                    <h3 class="one-line-ellipsis"><?php echo $one_book_recommendations['book_title']; ?></h3>
                                                    <h4 class="one-line-ellipsis"><?php echo $one_book_recommendations['book_author']; ?></h4>
                                                </div>
                                                <div class="list-recommendations col-xs-9">
                                                    <ul>
                                                        <?php foreach ( $one_book_recommendations['recommendations'] as $i => $one_person_recommendation ) : ?>
                                                            <?php if ( $i < 3 ) : ?>
                                                                <li>
                                                                    <div class="one-recommendation">
                                                                        <blockquote class="quote"><?php echo $one_person_recommendation['text']; ?></blockquote>
                                                                        <h3 class="one-line-ellipsis"><?php echo $one_person_recommendation['person_name']; ?></h3>
                                                                        <a href="<?php echo $one_person_recommendation['person_url']; ?>">
                                                                            <img class="img-adapt" src="<?php echo $one_person_recommendation['person_image']; ?>">
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                            <?php endif ?>
                                                        <?php endforeach ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endif ?>  
                        <?php endforeach ?> 
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#recommandations-populaires" data-slide="prev">
                        <div class="glyphicon glyphicon-chevron-left"></div>
                        <span class="sr-only">Précédent</span>
                    </a>
                    <a class="right carousel-control" href="#recommandations-populaires" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Suivant</span>
                    </a>

                </div>
            <?php endif ?>


            <!-- Jumping icon section beginning -->
            <div class="scroll-down" address="true"></div>
            <!-- Jumping icon section end -->

        </div>
        <!-- End Homepage Welcome Text -->

    </header>

<!-- End Homepage Presentation -->
<?php



//........................................................................
// HOMEPAGE PERSONS SECTION : RECOVERING PERSONS
//........................................................................

// Clearing any previous query
wp_reset_query();


// Building the arguments for the WP Query to get ALL the Person pages
$args = array(
    'post_type' => 'person',
    'post_status' => 'publish',
    'posts_per_page' => 20,
    'orderby' => 'rand'
    );

// Sending the WP_Query
$wp_query = new WP_Query( $args );

// Setting the person preview image size 
$img_size = 'themeora-portfolio-span-8';



//........................................................................
// HOMEPAGE'S PERSONS SECTION : PERSONS MOSAIC
//........................................................................

if ( $wp_query->have_posts() ) : ?>
    
    <!-- Persons Mosaic -->  
    <ul id="personnalites" class="portfolio-cols-4">
        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post();

            // Recover useful attributes from the Person
            $person_page_id = $wp_query->post->ID;
            $person_name = get_the_title();
            $person_intoduction = get_post_meta( $person_page_id, 'introduction', true);

            // Check if the portfolio has an image. Only load the item if it does
            if ( has_post_thumbnail( $person_page_id ) ) :
                $previewImage = wp_get_attachment_image_src( get_post_thumbnail_id( $person_page_id ), $img_size ); ?>
                <li class="masonry-item">
                    <div class="person">
                        <a href="<?php echo the_permalink($person_page_id); ?>" class="portfolio-link">
                            <img src="<?php echo $previewImage[0] ?>" class="img-adapt" alt="<?php echo $person_name; ?>" />
                            <div class="portfolio-details">
                                <div class="details-person-name">
                                    <h2><?php echo $person_name; ?></h2>
                                </div>
                                <div class="details-person-introduction">
                                    <?php if ( $person_intoduction ) : ?>
                                        <h4><?php echo $person_intoduction; ?></h4>
                                    <?php endif; ?>
                                </div>
                                <div class="details-person-invitation">
                                    <h4>Ses recommandations de lecture</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </li>
            <?php endif; ?>
        <?php endwhile; ?>
    </ul>
    <!-- End Persons Mosaic -->  

<?php endif; 
wp_reset_query();



//........................................................................
// FOOTER SECTION 
//........................................................................

get_footer(); ?>