<?php

//........................................................................
// HEADER SECTION
//........................................................................

get_header();



//........................................................................
// PERSON SECTION 
//........................................................................

$person_page_id = get_the_id();
$person_recommendations = get_person_recommendations( $person_page_id );
$num_recommendations = count( $person_recommendations['recommendations'] ); ?>

<div class="book-page container">
    <header class="row">

        <!-- Person Cover --> 
        <div class="book-cover col-sm-4 col-sm-push-7">
            <img src='<?php echo $person_recommendations['person_image']; ?>'>
        </div>

        <!-- Person Presentation --> 
        <div class="col-sm-6 col-sm-pull-4 col-sm-offset-1">

            <h1><?php echo $person_recommendations['person_name']; ?></h1>

            <h2><?php echo $person_recommendations['person_introduction']; ?></h2>

            <?php if ( $person_recommendations['person_bio'] ) : ?>
                <div><?php echo $person_recommendations['person_bio']; ?></div>
            <?php endif; ?>

        </div>

    </header>

    <!-- Book Recommendations Section --> 
    <?php if ( $num_recommendations > 0 ) : ?>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">

                <h2>
                    <?php if( $num_recommendations == 1 ) : ?>
                        Un livre recommandé par
                    <?php else : ?>
                        <?php echo $num_recommendations . ' '; ?>recommandés par
                    <?php endif; ?>
                    <?php echo ' ' . $person_recommendations['person_name']; ?>
                </h2>

                <ul>
                    <?php foreach ( $person_recommendations['recommendations'] as $recommendation ) : ?>
                            
                        <li class="book-recommendation row">

                            <!-- Book Cover --> 
                            <div class="col-sm-3 recommender-portrait">
                                <a href="<?php echo $recommendation['book_url']; ?>">
                                    <img src="<?php echo $recommendation['book_image']; ?>" alt="<?php echo $book_title; ?>"/>
                                    <p><?php echo $recommendation['book_title']; ?></p>
                                </a>
                            </div>

                            <!-- Recommendation Text --> 
                            <div class="col-sm-9">
                                <a href="<?php echo $recommendation['book_url']; ?>">
                                    <h3><?php echo $recommendation['book_title']; ?></h3>
                                    <h4><?php echo ' - ' . $recommendation['book_author'] . ' - '; ?></h4>
                                </a>
                                
                                <div class="book-recommendation-text inspirama-quote">
                                    <?php echo $recommendation['text']; ?>
                                </div>

                                <ul class="book-recommendation-sources one-line-ellipsis">
                                    Source(s) :
                                    <?php for ($i = 0; $i < count( $recommendation['sources_titles'] ); $i++) : ?>
                                        <li>
                                            <?php if( $i > 0 ) : ?> | <?php endif; ?>
                                            <a target="_blank" href="<?php echo $recommendation['sources_urls'][$i] ?>">
                                                <?php echo $recommendation['sources_titles'][$i] ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>

                            </div>

                        </li>

                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>












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
                <h2>Livres recommandés par<?php echo ' ' . $person_name; ?></h2>
        	<br/>
        </div>

        <div class="portfolio-books-wrapper">
            <ul id="masonry-wrapper" class="portfolio-cols-4">
            
            <?php 

            // The iterator will let us keep track of at which Book in the Recommendation array we are
            $iterator = 0;

            // We load the sellers logos only once : outside of the while loop
            $book_leslibraires_logo = get_stylesheet_directory_uri() . '/img/les_libraires.png' ;
            $book_amazon_logo = get_stylesheet_directory_uri() . '/img/amazon.png' ;
            $book_fnac_logo = get_stylesheet_directory_uri() . '/img/fnac.png' ;
            $book_priceminister_logo = get_stylesheet_directory_uri() . '/img/priceminister.png' ;
            $book_recyclivre_logo = get_stylesheet_directory_uri() . '/img/recyclivre.png' ;
            $book_ebook_logo = get_stylesheet_directory_uri() . '/img/ebooks.png' ;
            $book_gutenberg_logo = get_stylesheet_directory_uri() . '/img/gutenberg.png' ;

            while ( $wp_query->have_posts() ) :

                $wp_query->the_post();

                // Recover useful attributes from the Book
                $book_page_id = $wp_query->post->ID;
                $book_title = get_the_title();
                $book_author = get_post_meta( $book_page_id, 'author', true);
                $book_genre = get_post_meta( $book_page_id, 'genre', true);
                $book_theme = get_post_meta( $book_page_id, 'theme', true);
                $book_rewards = get_post_meta( $book_page_id, 'rewards', true);

                // Sellers URLs
                $book_leslibraires_url = get_post_meta( $book_page_id, 'leslibraires_url', true );
                $book_amazon_url = get_post_meta( $book_page_id, 'amazon_url', true );
                $book_fnac_url = get_post_meta( $book_page_id, 'fnac_url', true );
                $book_priceminister_url = get_post_meta( $book_page_id, 'priceminister_url', true );
                $book_recyclivre_url = get_post_meta( $book_page_id, 'recyclivre_url', true );
                $book_ebook_url = get_post_meta( $book_page_id, 'ebook_url', true );
                $book_gutenberg_url = get_post_meta( $book_page_id, 'gutenberg_url', true );

                // Recover useful attributes from the Recommendation
                $recommendation = $recommendations_array[ $iterator ];
                $recommendation_id = $recommendation->term_id;
                $recommendation_text = $recommendation->description;
                $recommendation_sources_titles = get_term_meta( $recommendation_id, 'sources_titles', true);
                $recommendation_sources_urls = get_term_meta( $recommendation_id, 'sources_urls', true);


                // Check if the Book has an image. Only load the Book if it does
                if ( has_post_thumbnail( $book_page_id ) ) {
                    $previewImage = wp_get_attachment_image_src( get_post_thumbnail_id( $book_page_id ), $img_size ); ?>

                    <!--  Book Frame -->
                    <li class="masonry-item">
                        <figure 
                            data-person="<?php echo $person_name; ?>"

                            data-title="<?php echo $book_title; ?>" 
                            data-author="<?php echo $book_author; ?>"

                            data-link="<?php echo the_permalink(); ?>"
                            data-genre="<?php echo $book_genre; ?>"
                            data-theme="<?php echo $book_theme; ?>"
                            data-rewards="<?php echo $book_rewards; ?>"

                            data-recommendation="<?php echo htmlspecialchars( $recommendation_text ); ?>"
                            data-sources-titles="<?php echo $recommendation_sources_titles; ?>"
                            data-sources-urls="<?php echo $recommendation_sources_urls; ?>"

                            data-leslibraires-url="<?php echo $book_leslibraires_url; ?>"
                            data-amazon-url="<?php echo $book_amazon_url; ?>"
                            data-fnac-url="<?php echo $book_fnac_url; ?>"
                            data-priceminister-url="<?php echo $book_priceminister_url; ?>"
                            data-recyclivre-url="<?php echo $book_recyclivre_url; ?>"
                            data-ebook-url="<?php echo $book_ebook_url; ?>"
                            data-gutenberg-url="<?php echo $book_gutenberg_url; ?>"

                            data-leslibraires-logo="<?php echo $book_leslibraires_logo; ?>"
                            data-amazon-logo="<?php echo $book_amazon_logo; ?>"
                            data-fnac-logo="<?php echo $book_fnac_logo; ?>"
                            data-priceminister-logo="<?php echo $book_priceminister_logo; ?>"
                            data-recyclivre-logo="<?php echo $book_recyclivre_logo; ?>"
                            data-ebook-logo="<?php echo $book_ebook_logo; ?>"
                            data-gutenberg-logo="<?php echo $book_gutenberg_logo; ?>"
                            >
                            <a href="#" class="portfolio-link">
                                
                                <!--  Book Image Button Effect -->
                                <div class="button-effect">
                                    <img src="<?php echo $previewImage[0] ?>" class="portfolio-book-image" alt="<?php the_title(); ?>" />
                                   
                                    <div class="portfolio-book-details">                                  
                                        <div class="portfolio-book-title">
                                            <h2><?php echo $book_title; ?></h2>
                                        </div>                                  
                                        <div class="portfolio-book-author">
                                            <?php if( $book_author != ' ') : ?>
                                                <h4>de<?php echo ' ' . $book_author; ?></h4>
                                            <?php endif; ?>
                                        </div>                                    
                                        <div class="portfolio-book-invitation">
                                            <h4>L'avis de<?php echo ' ' . $person_name; ?></h4>
                                        </div>
                                    </div>
                                </div>

                                <!--  Book Details -->
                                <div class="portfolio-book-subtitle-title one-line-ellipsis">
                                    <?php echo $book_title; ?>
                                </div>
                                <div class="portfolio-book-subtitle-author one-line-ellipsis">
                                    <?php if( $book_author != ' ') : ?>
                                        de<?php echo ' ' . $book_author; ?>
                                    <?php endif; ?>
                                </div>

                            </a>
                        </figure>
                    </li>
                    <!-- End Book Frame -->

                <?php } 
                ++$iterator; 

            endwhile; ?>

                <li class="masonry-item">
                    <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSeyVqJhmWZGhd5YwYmBKaTq4JyIxGCxT3t7tUlipAVZbAiVGg/viewform?usp=sf_link" class="portfolio-link">
                        
                        <!-- Button Effect -->
                        <div class="button-effect-more">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/img/add_book.png' ; ?>" class="portfolio-book-more" alt="Suggérer une lecture de<?php echo ' ' . $person_name; ?>" />
                           
                            <div class="portfolio-book-details">                                                                                                      
                                <div class="portfolio-book-more-invitation">
                                    <h4>Suggérer une nouvelle lecture de<?php echo ' ' . $person_name; ?></h4>
                                </div>
                            </div>
                        </div>

                    </a>
                </li>

            </ul>
        </div>
        <!-- End Books Mosaic -->  

    <?php
    wp_reset_query();
    endif;

// If there are no books to display
else : ?>

    <div class="text-center">
        <br><br><br><br>
        <p>
            Désolé, les livres recommandés par<?php echo ' ' . $person_name . ' '; ?>sont indisponibles pour l'instant. 
            <br>Continuez à explorer Inspirama pour plus de lectures inspirantes !
        </p>
        <br><br><br><br>
    </div>

<?php endif;













//........................................................................
// FOOTER SECTION 
//........................................................................

get_footer(); ?>