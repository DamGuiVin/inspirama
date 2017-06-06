<?php 





get_header();



// Get theme options





/*

THIS IS THE TEMPLATE-HOME ADAPTED TO CATEGORIES WITH IMAGES

IT IS BUILT TO DISPLAY THE CATEGORY NAME ALONG WITH ITS ASSOCIATED PIC IN THE BACKGROUND, 

FOLLOWED BY A MOSAIC OF THE ASSOCIATED PERSONS



get_the_category()

RETURNS THE ARRAY OF CURRENT CATEGORIES, WITH THE ONE WE WANT IN [0]



get_the_category()[0] IS A MAP OF THE CATEGORY INFOS:

WP_Term Object ( 

    [Term_id] => 10 

    [Name] => Entrepreneurs 

    [Slug] => Entrepreneurs 

    [Term_group] => 0 

    [Term_taxonomy_id] => 10 

    [Taxonomy] => Category 

    [Description] => Ici C'est La Categorie Entrepreneurs

    [Parent] => 0 

    [Count] => 4 

    [Filter] => Raw 

    [Cat_ID] => 10 

    [Category_count] => 4 

    [Category_description] => Ici C'est La Categorie Entrepreneurs 

    [Cat_name] => Entrepreneurs 

    [Category_nicename] => Entrepreneurs 

    [Category_parent] => 0 )

*/



// Getting necessary category variables

$current_category = get_the_category()[0];

$category_name = $current_category->name;





// Get the featured image to set as the background of the header. Use header_image if set, featured image if not



$background_image = z_taxonomy_image_url($current_category->term_id);

/*

if ( wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full-size' ) ) {



    $background_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full-size' );



    $background_image = $background_image[0];



}



if ( get_header_image() ) {



    $background_image = get_header_image();



}

*/

    



// Setup paging for portfolio pagaination



if ( get_query_var('paged') ) {



    $paged = get_query_var('paged');



} elseif ( get_query_var('page') ) {



    $paged = get_query_var('page');



} else {



    $paged = 1;



}





// Set a variable to tell us if there are pagination links to we can take care of spacing issues



$pagination = false;



?>





<?php 



// Only show this section of the first page



if ( $paged === 1 ) : ?>

    <header class=  "full-width-container-category center-page welcome-screen <?php $background_image != '' ? print 'header-with-background' : '' ?> <?php has_excerpt() ? print 'header-with-excerpt ' : print 'header-without-excerpt'; ?>" role="banner" data-welcome-background="<?php echo $background_image; ?>" >

        <div class="container welcome-container-category">

            <div class="row welcome-row">

                 <div class="col-md-10 col-md-offset-1">

                    <h1 class=""><?php echo $category_name ?></h1>

                    <?php /*
                    if ( has_excerpt() ) {
                        the_excerpt();
                    }*/
                    ?>

             </div><!-- end col-md-10 -->

            </div><!-- end row -->

        </div><!-- end container -->

    </header><!-- end header - full width container -->

    <?php wp_reset_query(); ?>

<?php endif; ?>











<?php



$layout = get_theme_mod('themeora_blog_layout', 'full-width');



?>



















<?php



// ATTEMPT TO BUILD SAME PORTFOLIO STRUCTURE AS HOME BUT WITH TAGS



/*

$args = array ( 'category' => $current_category->term_id, 'posts_per_page' => -1);

$people_list = get_posts( $args );

RETURNS THE ARRAY OF THE PEOPLE ASSOCIATED TO THE CURRENT CATEGORY



print_r($people_list[i])    RETURNS THE FOLLOWING TAG STRUCTURE:

WP_Post Object ( 

    [ID] => 61 

    [post_author] => 1 

    [post_date] => 2017-02-16 11:20:15 

    [post_date_gmt] => 2017-02-16 10:20:15 

    [post_content] => Salut, je suis un illustre pedophile 

    [post_title] => Jacques A. Granjon 

    [post_excerpt] => 

    [post_status] => publish 

    [comment_status] => closed 

    [ping_status] => closed 

    [post_password] => 

    [post_name] => joey-star    //THIS IS JUST A PROBLEM IN OUR OWN DECLARATION OF THE POSTS NAMES IN REFERENCE...

    [to_ping] => 

    [pinged] => 

    [post_modified] => 2017-04-16 18:54:49 

    [post_modified_gmt] => 2017-04-16 16:54:49 

    [post_content_filtered] => 

    [post_parent] => 0 

    [guid] => http://yeswekant.com/?page_id=61 

    [menu_order] => 0 

    [post_type] => page 

    [post_mime_type] => 

    [comment_count] => 0 

    [filter] => raw 

    )

*/



// Declaration of the useful variables to build the mosaic section

$img_size = 'themeora-portfolio-span-8';

$args = array ( 'category' => $current_category->term_id, 'posts_per_page' => -1);  //-1 in the last argument means infinite

$people_list = get_posts( $args );

$num_people = count( $people_list );


if ( $num_people > 0 ) : ?>

    <ul id="masonry-wrapper" class="portfolio-cols-4">

        <?php foreach ($people_list as $current_person) : 

            // Declaration of the useful variables to build an individual tile of the mosaic
            $person_name = $current_person->post_title;
            $person_page_id = $current_person->ID;
            $person_url = get_post_permalink( $person_page_id );   
            $person_intoduction = get_post_meta( $person_page_id, 'introduction', true);

            // Only create the tile if the Person has an associated thumbnail
            if ( has_post_thumbnail( $person_page_id ) ) :
                $previewImage = wp_get_attachment_image_src( get_post_thumbnail_id( $person_page_id ), $img_size );
            ?>  

                <li class="masonry-item">

                    <div class="person">

                        <a href="<?php echo $person_url; ?>" class="portfolio-link">

                            <img src="<?php echo $previewImage[0] ?>" class="img-adapt" alt="<?php echo $person_name; ?>" />

                            <div class="portfolio-details">

                                <div class="details-person-name">

                                    <h2 class="details-person-name"><?php echo $person_name; ?></h2>

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

                </li><!-- masonry-item -->

        <?php endif; ?>

        <?php endforeach; ?>

    </ul><!-- posts-wrapper -->








<?php



wp_reset_query();



endif;



?>





<!--  we don't show the content of the portfolio

    

<?php



/* Show the post content after the portfolio if set



--------------------------------------------------------------------------------------- */



$person_page_content = get_the_content();



if ( !empty( $person_page_content ) && $paged === 1 ) :



?>



<div class="full-width-container main-content-area <?php $pagination === true ? print 'no-top-padding' : '' ?>">



    <div class="container">



        <div class="col-md-12 homepage-content">



            <?php while ( have_posts() ) : the_post(); ?>



              <?php the_content(); ?>



            <?php endwhile; ?>



        </div>



    </div>



</div>



<?php endif; ?>



-->





<?php get_footer(); ?>