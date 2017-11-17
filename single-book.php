<?php

//........................................................................
// HEADER SECTION
//........................................................................

get_header();



//........................................................................
// BOOK PRESENTATION SECTION : RECOVERING PEOPLE
//........................................................................

// Book Details
$book_page_id = get_the_id();

$book_title = get_the_title();
$book_slug_title = get_post_field( 'post_name', get_post() );
$book_author = get_post_meta( $book_page_id, 'author', true);
$book_summary = get_post_meta( $book_page_id, 'summary', true);
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

// Sellers Logos
$book_leslibraires_logo = get_stylesheet_directory_uri() . '/img/les_libraires.png' ;
$book_amazon_logo = get_stylesheet_directory_uri() . '/img/amazon.png' ;
$book_fnac_logo = get_stylesheet_directory_uri() . '/img/fnac.png' ;
$book_priceminister_logo = get_stylesheet_directory_uri() . '/img/priceminister.png' ;
$book_recyclivre_logo = get_stylesheet_directory_uri() . '/img/recyclivre.png' ;
$book_ebook_logo = get_stylesheet_directory_uri() . '/img/ebooks.png' ;
$book_gutenberg_logo = get_stylesheet_directory_uri() . '/img/gutenberg.png' ;

// Book Recommendations : Recovering the IDS of the Recommendations
$all_recommendations = get_terms( array( 'taxonomy' => 'recommendation', 'orderby' => 'name' ));
$recommendations_ids = array();

foreach( $all_recommendations as $term ) {
    $key = get_term_meta( $term->term_id, 'book_title', true );
    if( $key == $book_slug_title ) {
        $recommendations_ids[] = $term->term_id;
    }
}

// Book Recommendations : Building the arguments for the WP_Query
$args = array(
    'post_type' => 'person',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
    'tax_query' => array(
            array(
            'taxonomy' => 'recommendation',
            'field'    => 'term_id',
            'terms'    => $recommendations_ids,
        ),
    ),
);

// Book Recommendations : Sending the WP_Query
$recommendations_query = new WP_Query( $args );



//........................................................................
// BOOK PRESENTATION SECTION : RECOVERING PEOPLE
//........................................................................

?>
<div class="full-width-container-book main-content-area">  
    <div class="container">
        <div class="row">

            <div class="col-md-3 img-responsive center-block">
                <?php if ( has_post_thumbnail() ) {
                    the_post_thumbnail();
                } ?>

                <!-- Affiliation Section -->  
                <div class="book-page-affiliation">
                    <h4>Soutenir Inspirama en achetant ce livre</h4>

                    <?php if ( $book_amazon_logo && $book_amazon_url ) : ?> 
                        <a target="_blank" href="<?php echo $book_amazon_url; ?>" title="Amazon"> <img class="social-media-icon" src="<?php echo $book_amazon_logo; ?>" alt="" height="64" width="64"/> </a>
                    <?php endif;

                    if ( $book_leslibraires_logo && $book_leslibraires_url ) : ?>
                        <a target="_blank" href="<?php echo $book_leslibraires_url; ?>" title="Les Libraires"> <img class="social-media-icon" src="<?php echo $book_leslibraires_logo; ?>" alt="" height="64" width="64"/> </a>
                    <?php endif;
 
                    if ( $book_fnac_logo && $book_fnac_url ) : ?>
                        <a target="_blank" href="<?php echo $book_fnac_url; ?>" title="La Fnac"> <img class="social-media-icon" src="<?php echo $book_fnac_logo; ?>" alt="" height="64" width="64"/> </a>
                    <?php endif;

                    if ( $book_priceminister_url && $book_priceminister_logo ) : ?>
                        <a target="_blank" href="<?php echo $book_priceminister_url; ?>" title="PriceMinister"> <img class="social-media-icon" src="<?php echo $book_priceminister_logo; ?>" alt="" height="64" width="64"/> </a>
                    <?php endif;

                    if ( $book_recyclivre_url && $book_recyclivre_logo ) : ?>
                        <a target="_blank" href="<?php echo $book_recyclivre_url; ?>" title="RecycLivre"> <img class="social-media-icon" src="<?php echo $book_recyclivre_logo; ?>" alt="" height="64" width="64"/> </a>
                    <?php endif;

                    if ( $book_ebook_url && $book_ebook_logo ) : ?>
                        <a target="_blank" href="<?php echo $book_ebook_url; ?>" title="EBook"> <img class="social-media-icon" src="<?php echo $book_ebook_logo; ?>" alt="" height="64" width="90"/> </a>
                    <?php endif;

                    if ( $book_gutenberg_url && $book_gutenberg_logo ) : ?>
                        <a target="_blank" href="<?php echo $book_gutenberg_url; ?>" title="Gutenberg Project"> <img class="social-media-icon" src="<?php echo $book_gutenberg_logo; ?>" alt="" height="64" width="64"/> </a>
                    <?php endif; ?>
                </div>
                <!-- End Affiliation Section --> 

            </div>

            <div class="col-md-9">

                <!-- Book Details Section --> 
                <div class="container">
                    <div class="row">

                        <div class="col-md-6">
                            <h1 class="book-page-title">
                                <?php echo $book_title; ?>
                            </h1>

                            <h2 class="book-page-author">
                                <?php if( $book_author != ' ') : ?>
                                    de<?php echo ' ' . $book_author; ?>
                                <?php endif ?>
                            </h2>
                        </div>

                    </div>
                </div>

                <div>
                    <div class="container book-page-details">
                        <div class="row">
                            <?php if( $book_genre ) : ?>
                                <div class="col-md-3">
                                    Genre :<?php echo ' ' . $book_genre; ?>
                                </div>
                            <?php endif; ?>

                            <?php if( $book_theme ) : ?>
                                <div class="col-md-3">
                                    Theme :<?php echo ' ' . $book_theme; ?>
                                </div>
                            <?php endif; ?>

                            <?php if( $book_rewards ) : ?>
                                <div class="col-md-3">
                                    Prix Littéraires :<?php echo ' ' . $book_rewards; ?>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                    </div>
        		</div>
                <!-- End Book Details Section --> 

                <!-- Book Recommendations Section --> 
                <?php if ( $recommendations_query->have_posts() ) : ?>

                    <div class = "book-page-recommendations">

                        <div class="text-center">
                            <h2>Ils recommandent<?php echo ' ' . $book_title; ?></h2>
                        </div>

                        <ul>
                            <?php 

                            // The iterator will let us keep track of at which Book in the Recommendation array we are
                            $iterator = 0;

                            while ( $recommendations_query->have_posts() ) : $recommendations_query->the_post();

                                // Recover useful attributes from the Person
                                $person_page_id = $recommendations_query->post->ID;
                                $person_name = get_the_title();
                                $person_introduction = get_post_meta( $person_page_id, 'introduction', true);

                                // Recover Person Image
                                $img_size = '(100,400,false)';
                                $previewImage = wp_get_attachment_image_src( get_post_thumbnail_id( $person_page_id ), $img_size );

                                // Recover useful attributes from the Recommendation
                                $recommendation_id = $recommendations_ids[ $iterator ];
                                $recommendation = get_term_by( 'id', $recommendation_id, 'recommendation' );
                                $recommendation_text = $recommendation->description;
                                $recommendation_sources_titles = explode( ';', get_term_meta( $recommendation_id, 'sources_titles', true) );
                                $recommendation_sources_urls =  explode( ';', get_term_meta( $recommendation_id, 'sources_urls', true) );

                                $iterator = $iterator + 1;

                                if( $recommendation_text and $recommendation_text != ' ') : ?>
                                    
                                    <li>

                                        <div class="container book-page-recommendations">
                                            <div class="row">

                                                <!-- Recommendation Text Section --> 
                                                <div class="col-md-6">
                                                    <div class="book-page-recommendations-text">
                                                        <?php echo $recommendation_text; ?>
                                                    </div>
                                                    <div class="book-page-recommendations-text">
                                                        Source(s) :
                                                        <?php for ($i = 0; $i < count( $recommendation_sources_titles ); $i++) : 
                                                            if( $i > 0 ) : ?>
                                                                 | 
                                                            <?php endif; ?>
                                                            <span>
                                                                <a target="_blank" href="<?php echo $recommendation_sources_urls[$i] ?>"><?php echo $recommendation_sources_titles[$i] ?></a>
                                                            </span>
                                                        <?php endfor; ?>
                                                    </div>
                                                </div>
                                                <!-- End Recommendation Text Section --> 

                                                <!-- Recommender Picture Section --> 
                                                <div class="col-md-3">
                                                    <div class="book-page-recommendations-person">
                                                        <a href="<?php echo the_permalink($person_page_id); ?>" class="portfolio-link">
                                                            <img src="<?php echo $previewImage[0] ?>" class="img-adapt" alt="<?php echo $person_name; ?>" height="120" width="120"/>
                                                            <div class="portfolio-details">
                                                                <div class="details-person-name">
                                                                    <h2 class="details-person-name"><?php echo $person_name; ?></h2>
                                                                </div>
                                                                <div class="details-person-introduction">
                                                                    <?php if ( $person_introduction ) : ?>
                                                                        <h4><?php echo $person_introduction; ?></h4>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="details-person-invitation">
                                                                    <h4>Découvrez ses autres recommandations de lecture</h4>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- End Recommender Picture Section --> 
                                                
                                            </div>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                    
                <?php endif; ?>
                <!-- End Book Recommendations Section --> 



                <!-- Book Summary Section --> 
                
                <div class="text-center book-page-summary-title">
                    <h2>Résumé de<?php echo ' ' . $book_title; ?></h2>
                </div>
                <div class="book-page-recommendation-summary">
            		<?php if ( $book_summary ) : echo $book_summary; 
                    else : echo "Désolé, nous n'avons pas encore de résumé disponible pour ce livre.";
                    endif; ?>
                </div>

			</div>
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end main-content-area -->


<?php 
wp_reset_query();



//........................................................................
// HEADER SECTION
//........................................................................

get_footer(); ?>


