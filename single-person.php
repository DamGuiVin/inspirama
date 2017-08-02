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
                            <div class="person-page-large-portrait">
                                <?php echo get_the_post_thumbnail( $post->ID, array(300,300) ); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Person Name, Intro and Bio -->
                    <div class="col-md-8">

                        <div class="person-page-name">
                            <h1><?php the_title(); ?></h1>
                        </div>

                        <div class="person-page-intro">
                            <h2><?php echo get_post_meta( $post->ID, 'introduction', true); ?></h2>
                        </div>
                        
                        <div class="person-page-bio">
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

// If the array of books is empty, we will use this
$wp_query = false;

// Building the arguments for the WP Query
if ( count($slug_book_titles_array) > 0 ) {
    $args = array(
        'post_type' => 'book',
        'post_name__in' => $slug_book_titles_array,
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'name',
        'order' => 'ASC'
        );

    // Sending the WP_Query
    $wp_query = new WP_Query( $args );
}

/*  Changement de la taille de l'image par Guilhem 
Précédemment $img_size = 'themeora-portfolio-span-8' 
maintenant ce sera $img_size = '( 200, 800, false )''
ce qui permet de la redimensionner au format livre  */
$img_size = '(200,800,false)';



//........................................................................
// PERSON RECOMMENDATIONS SECTION : BOOK MOSAIC
//........................................................................

// If there are books to display
if ( $wp_query ) : 
    if ( $wp_query->have_posts() ) : ?>

        <!-- Books Mosaic -->  
        <div class="text-center">
        	<br/>
                <h2>Livres recommandés par <?php echo $person_name; ?></h2>
        	<br/>
        </div>

        <div class="portfolio-books-wrapper">
            
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
                    $previewImage = wp_get_attachment_image_src( get_post_thumbnail_id( $book_page_id ), $img_size ); 

                    if ( $iterator % 4 == 0 ) { ?>
                        <ul id="books-portfolio-wrapper" class="portfolio-cols-4">
                    <?php } ?>

                            <!--  Book Frame -->
                            <li class="masonry-item">
                                <figure data-title="<?php echo $book_title; ?>" data-desc="<?php echo $book_author; ?>">
                                    <a href="#" class="image-link portfolio-link">
                                        
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
                                </figure>
                                
                            </li>
                            <!-- End Book Frame -->

                            <?php } 

                            if ( $iterator % 4 == 3 ) { ?>

                                <div class="image-details">
                                    <a href="#" class="image-details-close">Close</a>
                                    <div class="image-details-content">
                                        <figure class="image"></figure>
                                    </div>
                                    <div class="image-details-desc">
                                        <h3 class="image-details-title"></h3>
                                        <p class="image-details-text"></p>
                                    </div>
                                </div>
                            </ul>

                            <?php } 

                    ++$iterator; 

            endwhile; 
            
            if ( $iterator % 4 != 0 ) { ?>
                </ul>
            <?php } ?>

        </div>
        <!-- Books Mosaic -->  

    <?php
    wp_reset_query();
    endif;

// If there are no books to display
else : ?>

    <div class="text-center">
        <br><br><br><br>
        <p>
            Désolé, les livres recommandés par <?php echo $person_name; ?> sont indisponibles pour l'instant. 
            <br>Continuez à explorer Inspirama pour plus de lectures inspirantes !
        </p>
        <br><br><br><br>
    </div>

<?php endif;













//........................................................................
// FOOTER SECTION 
//........................................................................

get_footer(); ?>