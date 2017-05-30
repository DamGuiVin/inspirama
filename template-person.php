<?php

    /*
    * Template Name: Person
    */

//



// THIS IS THE BEGINNING OF THE PORTFOLIO ITEM


//

    get_header();

    // Get theme options

 ?>   


<div class="full-width-container single-portfolio main-content-area">

    <div class="container">

        <div class="row">



            <!-- page content -->

            <?php if ( have_posts() ) : 

                while ( have_posts() ) : the_post(); ?>

                    

                    <!-- Person Image -->

                    <div class="col-md-2 col-md-offset-3">

                    <?php if ( has_post_thumbnail( $post->ID ) ) : ?>

                            <div class="featured-image single-portfolio-featured-image">

			<?php echo get_the_post_thumbnail( $post->ID, 'themeora-thumbnail-span-8' ); ?>

                            </div>

                    <?php endif; ?>

                    </div>



                    <!-- Person Title, Excerpt and Content -->

                    <div class="col-md-4">

                        <div class="text-center">

			    <br/>

                            <h1><?php the_title(); ?></h1>

                            <?php if ( has_excerpt() ) : ?>

                                <div class="portfolio-intro">

                                    <?php the_excerpt(); ?>

                                </div>

                            <?php endif; ?>

                        </div>

                        <div class="text-justify post-content">

                                <?php the_content(); ?>

                        </div>

                        

                    </div>



                <?php endwhile; ?>

                



                <!-- .widget-area -->

                <?php if ( is_active_sidebar( 'Portfolio widget' ) ) : ?>

                <div class="row">

                    <div id="widget-area" class="portfolio-bottom-widget widget-area col-md-6 col-md-offset-3">

                            <?php dynamic_sidebar( 'Portfolio widget' ); ?>

                    </div>

                </div>

                <?php endif; ?>





            <?php endif; //have-posts ?>

          </div><!-- end row -->

    </div><!-- end Container -->

</div><!-- end full-width-container -->



















<?php



/* 



ATTEMPT TO BUILD SAME PORTFOLIO STRUCTURE FROM TAG RELATIONS



First, need to Query the Pages that follow template-book.php and that have the Tag matching the Person Slug Name ($post->post_name)

that we previously saved in the $person_slug_name variable



Then, we can build the portfolio from the array of posts we gathered



NB: FOR NOW, the link on the images of the mosaic (the Book covers) does not take the user to the 

Book pages, but directly to Amazon (the URL is not the permalink but the affiliate link)



*/





// Building the Query to get the Book Pages from the Tag

$max_num_books_per_page = -1;   // -1 means infinity

$person_slug_name = $post->post_name;   // This is the one we need for the tags

$person_name = $post->post_title;   // This one will be used later in the code



$args = array(

    'post_type' => 'page',

    'meta_key' => '_wp_page_template',

    'meta_value' => 'template-book.php',

    'tag' => $person_slug_name,

    'post_status' => 'publish',

    'posts_per_page' => $max_num_books_per_page,

    'orderby' => 'menu_order',

    'order' => 'ASC',

    'paged' => $paged

);





// Sending the WP_Query

$wp_query = new WP_Query( $args );





// Set the pagination variable to true if we have more than one page

if ( $wp_query->max_num_pages > 1 ) $pagination = true;





/* 

Changement de la taille de l'image par Guilhem 

Précédemment $img_size = 'themeora-portfolio-span-8' 

maintenant ce sera $img_size = '( 200, 800, false )''

ce qui permet de la redimensionner au format livre 

*/

$img_size = '(200,800,false)';





// Building the Book mosaic

if ( $wp_query->have_posts() ) : ?>



    <div class="text-center">

	<br/>

        <h2>Livres recommandés par <?php echo $person_name; ?></h2>

	<br/>

    </div>





    <ul id="masonry-wrapper" class="portfolio-cols-4">

        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

            <?php

            // Check if the Book has an image. Only load the Book if it does

            if ( has_post_thumbnail( $wp_query->post->ID ) ) {

            $previewImage = wp_get_attachment_image_src( get_post_thumbnail_id( $wp_query->post->ID ), $img_size );

            $affiliation_url = get_post_meta( $wp_query->post->ID, 'affiliation_url', true );

            ?>

                <li class="masonry-item">



            <!--  Rajout de la classe button-effect pour pouvoir agir sur l'affichage de l'image -->

                <div class="button-effect">

                    <a target="_blank" href="<?php echo $affiliation_url ?>" class="portfolio-link" title="<?php the_title() ?>">

                        <img src="<?php echo $previewImage[0] ?>" class="image-style" alt="<?php the_title(); ?>" />

 <!--      enlève l'affichage du titre des livres         

		<div class="portfolio-details">

                <div class="details-text">

                <h2><?php the_title(); ?></h2>

                </div> 

                </div>

 -->

                      </div>

                    </a>

                </li><!-- masonry-item -->

            <?php } ?>

        <?php endwhile; ?>

    </ul><!-- posts-wrapper -->

  <!-- Enlève la pagination   <?php themeora_paging(); ?> -->



        </div>

    </div>



<?php

wp_reset_query();

endif; ?>







<?php get_footer(); ?>