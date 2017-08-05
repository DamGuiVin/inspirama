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
                ++$iterator; 

            endwhile; ?>
            </ul>
        <!-- End Books Mosaic -->  

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