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

            <!-- Top Recommendations Carousel -->
            <?php recommendations_carousel( array(  
                'les-freres-karamazov', 
                'le-cycle-de-fondation-tome-2-fondation-et-empire',
                'vagabonding',
                'le-petit-prince') ); ?>

            <!-- Jumping icon section beginning -->
            <div class="scroll-down" address="true"></div>
            <!-- Jumping icon section end -->

        </div>
        <!-- End Homepage Welcome Text -->

    </header>

<!-- End Homepage Presentation -->



<!-- Top Books Section -->
<div class="container-fluid">
    <div class="row">
        <div class="WAZAAAAA">
            
            <h2>Les livres recommandés par les 
                <div class="dropdown people-categories-dropdown">
                    <button class="btn btn-basic dropdown-toggle" type="button" data-toggle="dropdown">
                        Artistes<span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Entrepreneurs</a></li>
                        <li><a href="#">Artistes</a></li>
                        <li><a href="#">Politiciens</a></li>
                        <li><a href="#">Autres</a></li>
                    </ul>
                </div>
            </h2>

            <?php books_carousel(); ?>

        </div>
    </div>
</div>















<?php

/*

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

*/

//........................................................................
// FOOTER SECTION 
//........................................................................

get_footer(); ?>