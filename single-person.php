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
                    <div class="col-md-4">
                        <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                                <div class="featured-image single-portfolio-featured-image">
                                    <?php echo get_the_post_thumbnail( $post->ID, array(400,400) ); ?>
                                </div>
                        <?php endif; ?>
                    </div>

                    <!-- Person Title, Excerpt and Content -->
                    <div class="col-md-8">
                        <div class="name-person">
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
$slug_book_titles_array = array();
$recommendations_array = get_the_terms( $person_id, 'recommendation' );

if ( $recommendations_array ) {
    foreach ( $recommendations_array as $recommendation) {
    $recommendation_book_title = get_term_meta( $recommendation->term_id, 'book_title', true );
    array_push( $slug_book_titles_array, $recommendation_book_title );
    }
}


// Building the arguments for the WP Query
$args = array(
    'post_type' => 'book',
    'post_name__in' => $slug_book_titles_array,
    'post_status' => 'publish',
    'posts_per_page' => -1
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

    <div class="portfolio-books-wrapper">
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

                /* 
                PAS NECESSAIRE POUR L'INSTANT MAIS SERA UTILE POUR L'AFFICHAGE DE LA RECOMMENDATION DEPUIS LA PAGE PERSON

                // Recover useful attributes from the Recommendation
                $recommendation = $recommendations_array[ $iterator ];
                $recommendation_id = $recommendation->term_id;
                $recommendation_text = $recommendation->description;
                $recommendation_sources_titles = get_term_meta( $recommendation_id, 'sources_titles', true);
                $recommendation_sources_urls = get_term_meta( $recommendation_id, 'sources_urls', true);
                */

                // Check if the Book has an image. Only load the Book if it does
                if ( has_post_thumbnail( $book_page_id ) ) {
                    $previewImage = wp_get_attachment_image_src( get_post_thumbnail_id( $book_page_id ), $img_size ); ?>

                    <!--  Book Frame -->
                    <li class="masonry-item">

                        <a href="<?php the_permalink(); ?>" class="portfolio-link">
                            
                            <!--  Book Image Button Effect -->
                            <div class="button-effect">

                                <img src="<?php echo $previewImage[0] ?>" class="portfolio-book-image" alt="<?php the_title(); ?>" />
                                
                                <div class="portfolio-book-details">
                                
                                    <div class="portfolio-book-title">
                                        <h2><?php echo $book_title; ?></h2>
                                    </div>
                                
                                    <div class="portfolio-book-author">
                                        <?php if( $book_author != ' ') : ?>
                                            <h4>de <?php echo $book_author; ?></h4>
                                        <?php endif; ?>
                                    </div>
                                
                                    <div class="portfolio-book-invitation">
                                        <h4>L'avis de <?php echo $person_name; ?></h4>
                                    </div>
                                
                                </div>

                            </div>

                            <!--  Book Details -->
                            <div class="portfolio-book-subtitle-title">
                                <?php echo $book_title; ?>
                            </div>

                            <div class="portfolio-book-subtitle-author">
                                <?php if( $book_author != ' ') : ?>
                                    de <?php echo $book_author; ?>
                                <?php endif; ?>
                            </div>

                        </a>

                    </li>
                    <!-- End Book Frame -->

                <?php } 

                ++$iterator; 

            endwhile; ?>
        </ul>
    </div>
    <!-- Books Mosaic -->  

<?php
wp_reset_query();
endif;



//........................................................................
// FOOTER SECTION 
//........................................................................

get_footer(); ?>