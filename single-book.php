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
$book_image = wp_get_attachment_image_src( get_post_thumbnail_id( $book_page_id ), 'full' )[0];
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

// Book Recommendations : Saving the number of recommendations
$num_recommendations = count( $recommendations_ids );

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
<div class="book-page container">
    <header class="row">

        <!-- Book Cover --> 
        <div class="book-cover col-sm-4 col-sm-push-7">
            <img src='<?php echo $book_image; ?>'>
        </div>

        <!-- Book Presentation --> 
        <div class="col-sm-6 col-sm-pull-4 col-sm-offset-1">

            <h1><?php echo $book_title; ?></h1>

            <?php if( $book_author != ' ') : ?>
                <h2>de<?php echo ' ' . $book_author; ?></h2>
            <?php endif ?>

            <?php if ( $book_summary ) : ?>
                <div><?php echo $book_summary; ?></div>
            <?php endif; ?>

            <div class="book-info row">
                <em class="col-md-4">
                    <?php if( $book_genre ) : ?>
                        Genre :<?php echo ' ' . $book_genre; ?>
                    <?php endif; ?>
                </em>

                <em class="col-md-4">
                    <?php if( $book_theme ) : ?>
                        Theme :<?php echo ' ' . $book_theme; ?>
                    <?php endif; ?>
                </em>

                <em class="col-md-4">
                    <?php if( $book_rewards ) : ?>
                        Prix Littéraires :<?php echo ' ' . $book_rewards;  ?>
                    <?php endif; ?>
                </em>
            </div>
            
            <!-- Book Affiliation -->  
            <?php get_affiliation_dropdown( $book_page_id ); ?>

        </div>

    </header>

    <!-- Book Recommendations Section --> 
    <?php if ( $recommendations_query->have_posts() ) : ?>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">

                <h2>
                    <?php if( $num_recommendations == 1 ) : ?>
                        Une personnalité recommande
                    <?php else : ?>
                        <?php echo $num_recommendations . ' '; ?>personnalités recommandent
                    <?php endif; ?>
                    <?php echo ' ' . $book_title; ?>
                </h2>

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
                        $previewImage = wp_get_attachment_image_src( get_post_thumbnail_id( $person_page_id ));

                        // Recover useful attributes from the Recommendation
                        $recommendation_id = $recommendations_ids[ $iterator ];
                        $recommendation = get_term_by( 'id', $recommendation_id, 'recommendation' );
                        $recommendation_text = $recommendation->description;
                        $recommendation_sources_titles = explode( ';', get_term_meta( $recommendation_id, 'sources_titles', true) );
                        $recommendation_sources_urls =  explode( ';', get_term_meta( $recommendation_id, 'sources_urls', true) );

                        $iterator = $iterator + 1;

                        if( $recommendation_text and $recommendation_text != ' ') : ?>
                            
                            <li class="book-recommendation row">

                                <!-- Recommender Portait --> 
                                <div class="col-sm-3 recommender-portrait">
                                    <a href="<?php echo the_permalink($person_page_id); ?>">
                                        <img src="<?php echo $previewImage[0] ?>" alt="<?php echo $person_name; ?>"/>
                                        <p><?php echo $person_name; ?></p>
                                    </a>
                                </div>

                                <!-- Recommendation Text --> 
                                <div class="col-sm-9">
                                    <a href="<?php echo the_permalink($person_page_id); ?>">
                                        <h3><?php echo $person_name; ?></h3>
                                        <h4><?php echo ' - ' . $person_introduction . ' - '; ?></h4>
                                    </a>
                                    
                                    <div class="book-recommendation-text inspirama-quote">
                                        <?php echo $recommendation_text; ?>
                                    </div>

                                    <ul class="book-recommendation-sources one-line-ellipsis">
                                        Source(s) :
                                        <?php for ($i = 0; $i < count( $recommendation_sources_titles ); $i++) : ?>
                                            <li>
                                                <?php if( $i > 0 ) : ?> | <?php endif; ?>
                                                <a target="_blank" href="<?php echo $recommendation_sources_urls[$i] ?>">
                                                    <?php echo $recommendation_sources_titles[$i] ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>

                                </div>

                            </li>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>



<?php 
wp_reset_query();



//........................................................................
// HEADER SECTION
//........................................................................

get_footer(); ?>


