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
$background_image = '';

if ( wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full-size' ) ) {
    $background_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full-size' );
    $background_image = $background_image[0];
}

if ( get_header_image() ) {
    $background_image = get_header_image();
} ?>

<!-- Homepage Presentation -->
<header class="full-width-container-home center-page welcome-screen <?php $background_image != '' ? print 'header-with-background' : '' ?> <?php has_excerpt() ? print 'header-with-excerpt ' : print 'header-without-excerpt'; ?>" role="banner" data-welcome-background="<?php echo $background_image; ?>" >
    
  <!-- Homepage welcome Text -->
  <div class="container welcome-container-home">
      <div class="row welcome-row">
          <div class="col-md-10 col-md-offset-1">
              <?php while ( have_posts() ) : the_post(); ?>
                  <div id="bg">
                    <h1 class="title-homepage"><?php the_title(); ?><span class="element"></span><span class="typed-cursor"></span></h1>
                    <h2 class=""><?php the_content(); ?></h2>
                  </div>
                  <?php
                  if ( has_excerpt() ) {
                      the_excerpt();
                  } ?>
              <?php endwhile; ?>
          </div>
      </div>
  </div>
  <!-- End Homepage Welcome Text -->

  <!-- Button section beginning -->
  <div class="go-to-portfolio-link-container">
      <div class="go-to-portfolio-link-button">
          <a href="#masonry-wrapper" class="scroll-try scroll-down" address="true">
          </a>
      </div>
  </div>
  <!-- Button section end -->

</header>
<!-- End Homepage Presentation -->
<?php 

if ( $paged === 1 ) : ?>

    <?php if ( have_posts() ) : ?>

        <header class="full-width-container-home center-page welcome-screen <?php $background_image != '' ? print 'header-with-background' : '' ?> <?php has_excerpt() ? print 'header-with-excerpt ' : print 'header-without-excerpt'; ?>" role="banner" data-welcome-background="<?php echo $background_image; ?>" >

            <div class="container welcome-container-home">

                <div class="row welcome-row">

                    <div class="col-md-10 col-md-offset-1">

                        <?php while ( have_posts() ) : the_post(); ?>

                            <div id="bg">

                                <h1 class="title-homepage"><?php the_title(); ?><span class="element"></span><span class="typed-cursor"></span></h1>

                                <h2 class=""><?php the_content(); ?></h2>

                            </div>

                            <?php

                            if ( has_excerpt() ) {

                                the_excerpt();

                            } ?>

                        <?php endwhile; ?>

                    </div><!-- end col-md-10 -->

                </div><!-- end row -->

            </div><!-- end container -->

            <!-- Button section beginning -->
            <div class="go-to-portfolio-link-container">

                <div class="go-to-portfolio-link-button">
                    <a href="#masonry-wrapper" class="scroll-try scroll-down" address="true">
                    </a>

                </div>

            </div><!-- Button section end -->

        </header><!-- end header - full width container -->

        <?php wp_reset_query(); ?>

    <?php endif; ?>

<?php endif; ?>











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
    'posts_per_page' => -1
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
    <ul id="masonry-wrapper" class="portfolio-cols-4">
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
                                    <h4>Découvrez ses recommandations de lecture</h4>
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