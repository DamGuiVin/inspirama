<?php

//........................................................................
// HEADER SECTION
//........................................................................

    get_header();



//........................................................................
// PERSON PRESENTATION SECTION 
//........................................................................

?>   
<!-- Person Presentation -->   
<div class="full-width-container single-portfolio main-content-area">
    <div class="container">
        <div class="row">          
            <?php if ( have_posts() ) : 
                while ( have_posts() ) : the_post(); ?>
                    
                    <!-- Person Image -->
                    <div class="col-md-2 col-md-offset-3">
                        <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                                <div class="featured-image img-circle single-portfolio-featured-image">
                                    <?php echo get_the_post_thumbnail( $post->ID, array(400,400) ); ?>
                                </div>
                        <?php endif; ?>
                    </div>

                    <!-- Person Title, Excerpt and Content -->
                    <div class="col-md-4">
                        <div class="text-center">
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
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- End Person Presentation -->  
<?php



//........................................................................
// PERSON RECOMMENDATIONS SECTION : RECOVERING BOOKS
//........................................................................

// Retrieving the slug book titles from the Recommendations
$person_id = $post->ID;
$person_name = $post->post_title;
$recommendations_array = get_the_terms( $person_id, 'recommendation' );
$slug_book_titles_array = array();
if( $recommendations_array && !is_wp_error( $recommendations_array ) ) {
    foreach( $recommendations_array as $recommendation ) {
        array_push( $slug_book_titles_array, $recommendation->slug );
    }
}

// Maximum number of books to look for : -1 means infinity
$max_num_books_per_page = -1;   

// Building the arguments for the WP Query
$args = array(
    'post_type' => 'book',
    'post_name__in ' => $slug_book_titles_array,
    'post_status' => 'publish',
    'posts_per_page' => $max_num_books_per_page,
    );

// Sending the WP_Query
$wp_query = new WP_Query( $args );

/*  Changement de la taille de l'image par Guilhem 
Précédemment $img_size = 'themeora-portfolio-span-8' 
maintenant ce sera $img_size = '( 200, 800, false )''
ce qui permet de la redimensionner au format livre  */
$img_size = '(200,800,false)';



//........................................................................
// PERSON RECOMMENDATIONS SECTION : BOOK MOSAIC
//........................................................................

if ( $wp_query->have_posts() ) : ?>
    
    <!-- Books Mosaic -->  
    <div class="text-center">
    	<br/>
            <h2>Livres recommandés par <?php echo $person_name; ?></h2>
    	<br/>
    </div>

    <ul id="masonry-wrapper" class="portfolio-cols-4">
        <?php 

        // The iterator will let us keep track of at which Book in the Recommendation array we are
        $iterator = 0;

        while ( $wp_query->have_posts() ) : 

            $wp_query->the_post();

            // Recover useful attributes from the Book
            $book_page_id = $wp_query->post->ID;
            $book_title = get_the_title();
            $book_author = get_post_meta( $book_page_id, 'author', true);

            // Recover useful attributes from the Recommendation
            $recommendation_object = $recommendations_array[ $iterator ];
            $recommendation_id = $recommendation_object->term_id;
            $recommendation_text = $recommendation_object->description;
            $recommendation_source = get_term_meta( $recommendation_id, 'source', true);

            // Check if the Book has an image. Only load the Book if it does
            if ( has_post_thumbnail( $book_page_id ) ) {
                $previewImage = wp_get_attachment_image_src( get_post_thumbnail_id( $book_page_id ), $img_size ); ?>

                <!--  Book Frame -->
                <li class="masonry-item">

                    <!--  Book Image Button Effect -->
                    <div class="button-effect">
                        <a href="<?php the_permalink(); ?>" class="portfolio-link">
                            <img src="<?php echo $previewImage[0] ?>" class="portfolio-image-book" alt="<?php the_title(); ?>" />
                        </a>
                    </div>

                    <!--  Book Details -->
                    <div class="portfolio-book-subtitle">
                        <div>
                            <?php echo $book_title; ?>,
                        </div>
                        <div >
                            de <?php echo $book_author; ?>
                        </div>
                        <div >
                            La recommandation : <?php echo $recommendation_text; ?>
                        </div>
                        <div >
                            Source : <?php echo $recommendation_source; ?>
                        </div>
                    </div>

                </li>
                <!-- End Book Frame -->

            <?php } 

            ++$iterator; 

        endwhile; ?>
    </ul>
    <!-- Books Mosaic -->  

<?php
wp_reset_query();
endif;



//........................................................................
// FOOTER SECTION 
//........................................................................

get_footer(); ?>