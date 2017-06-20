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
$book_momox_url = get_post_meta( $book_page_id, 'momox_url', true );
$book_recyclivre_url = get_post_meta( $book_page_id, 'recyclivre_url', true );
$book_ebook_url = get_post_meta( $book_page_id, 'ebook_url', true );
$book_gutenberg_url = get_post_meta( $book_page_id, 'gutenberg_url', true );

// Sellers Logos
$book_leslibraires_logo = get_stylesheet_directory_uri() . '/img/les_libraires.png' ;
$book_amazon_logo = get_stylesheet_directory_uri() . '/img/amazon.png' ;
$book_fnac_logo = get_stylesheet_directory_uri() . '/img/fnac.png' ;
$book_priceminister_logo = get_stylesheet_directory_uri() . '/img/priceminister.png' ;
$book_ebook_logo = get_stylesheet_directory_uri() . '/img/ebooks.png' ;
$book_gutenberg_logo = get_stylesheet_directory_uri() . '/img/gutenberg.png' ;

// Book Recommendations : Recovering the IDS of the Recommendations
$all_recommendations = get_terms( array( 'taxonomy' => 'recommendation' ));
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
    'tax_query' => array(
            array(
            'taxonomy' => 'recommendation',
            'field'    => 'term_id',
            'terms'    => $recommendations_ids,
        ),
    ),
);

// Book Recommendations : Sending the WP_Query
$wp_query = new WP_Query( $args );



//........................................................................
// BOOK PRESENTATION SECTION : RECOVERING PEOPLE
//........................................................................

?>
<div class="full-width-container-book main-content-area">  
    <div class="container">
        <div class="row">

            <div class="col-md-3 img-responsive center-block">
                <?php if ( has_post_thumbnail() ) {
                    the_post_thumbnail( array(800,3200) );
                } ?>
            </div>

            <div class="col-md-8">

                <!-- Book Details Section --> 
                <div>
            		
                    <h1 class="booktitle">
                        <?php echo $book_title; ?></br>
                        de <?php echo $book_author; ?>
                    </h1>
                    <p>
                        Genre : <?php echo $book_genre; ?>
                    </p>
                    <p>
                        Theme : <?php echo $book_theme; ?>
                    </p>
                    <p>
                        Recompenses : <?php echo $book_rewards; ?>
                    </p>
        		</div>
                <!-- End Book Details Section --> 

                <!-- Book Recommendations Section --> 
                <?php if ( $wp_query->have_posts() ) : ?>

                    <div class="text-center">
                        <br/>
                            <h2>Les recommandations de <?php echo $book_title; ?></h2>
                        <br/>
                    </div>

                    <ul>
                        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post();

                            // Recover useful attributes from the Person
                            $person_page_id = $wp_query->post->ID;
                            $person_name = get_the_title();
                            $person_introduction = get_post_meta( $person_page_id, 'intro', true);

                            // Recover Person Image
                            $img_size = '(100,400,false)';
                            $previewImage = wp_get_attachment_image_src( get_post_thumbnail_id( $person_page_id ), $img_size );

                            // Recover useful attributes from the Recommendation
                            $recommendation_object = get_term_by( 'slug', $book_slug_title, 'recommendation' );
                            $recommendation_id = $recommendation_object->term_id;
                            $recommendation_text = $recommendation_object->description;
                            $recommendation_source = get_term_meta( $recommendation_id, 'source', true);
                            ?>

                            <li>

                                <p>La recommandation : <?php echo $recommendation_text; ?></p>
                                <p>La source : <?php echo $recommendation_source; ?></p>

                                <div class="person">
                                    <a href="<?php echo the_permalink($person_page_id); ?>" class="portfolio-link">
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
                                                <h4>Découvrez ses autres recommandations de lecture</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
                <!-- End Book Recommendations Section --> 



                <!-- Book Summary Section --> 
                <div>
            		<?php if ( $book_summary ) : ?>
                		<p class="summary"><b>Résumé : </b><?php echo $book_summary; ?></p>
                	<?php 
                    else : ?>
                        <p class="summary"><b>Résumé : </b>Désolé, nous n'avons pas encore de résumé pour ce livre dans notre base de données.</p>
                    <?php endif; ?>
                </div>

                <!-- Affiliation Section -->  
                <div>
            		<h4> Acheter ce livre : </h4>

            	    <?php if ( $book_amazon_logo && $book_amazon_url ) : ?>	
            	    	<a href="<?php echo $book_amazon_url; ?>" title="Amazon"> <img src="<?php echo $book_amazon_logo; ?>" alt="" height="32" width="32"/> </a>
            	    <?php endif;

            	    if ( $book_leslibraires_logo && $book_leslibraires_url ) : ?>
                	    <a href="<?php echo $book_leslibraires_url; ?>" title="Les Libraires"> <img src="<?php echo $book_leslibraires_logo; ?>" alt="" height="32" width="32"/> </a>
            	    <?php endif;
 
            	    if ( $book_fnac_logo && $book_fnac_url ) : ?>
                	    <a href="<?php echo $book_fnac_url; ?>" title="La Fnac"> <img src="<?php echo $book_fnac_logo; ?>" alt="" height="32" width="32"/> </a>
                	<?php endif;

                    if ( $book_priceminister_url && $book_priceminister_logo ) : ?>
                        <a href="<?php echo $book_priceminister_url; ?>" title="PriceMinister"> <img src="<?php echo $book_priceminister_logo; ?>" alt="" height="32" width="32"/> </a>
                    <?php endif;

                    if ( $book_momox_url && $book_momox_logo ) : ?>
                        <a href="<?php echo $book_momox_url; ?>" title="Momox"> <img src="<?php echo $book_momox_logo; ?>" alt="" height="32" width="32"/> </a>
                    <?php endif;

                    if ( $book_recyclivre_url && $book_recyclivre_logo ) : ?>
                        <a href="<?php echo $book_recyclivre_url; ?>" title="RecycLivre"> <img src="<?php echo $book_recyclivre_logo; ?>" alt="" height="32" width="32"/> </a>
                    <?php endif;

                    if ( $book_ebook_url && $book_ebook_logo ) : ?>
                        <a href="<?php echo $book_ebook_url; ?>" title="EBook"> <img src="<?php echo $book_ebook_logo; ?>" alt="" height="32" width="90"/> </a>
                    <?php endif;

                    if ( $book_gutenberg_url && $book_gutenberg_logo ) : ?>
                        <a href="<?php echo $book_gutenberg_url; ?>" title="Gutenberg Project"> <img src="<?php echo $book_gutenberg_logo; ?>" alt="" height="32" width="32"/> </a>
                    <?php endif; ?>
                </div>
                <!-- End Affiliation Section --> 

			</div>
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end main-content-area -->


<?php 
wp_reset_query();


get_footer(); ?>


