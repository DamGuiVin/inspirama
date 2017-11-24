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
$book_slug_title = get_post_field( 'post_name', get_post() );

$book_recommendations = get_book_recommendations( $book_slug_title );
$num_recommendations = count( $book_recommendations['recommendations'] );

//........................................................................
// BOOK PRESENTATION SECTION : RECOVERING PEOPLE
//........................................................................

?>
<div class="book-page container">
    <header class="row">

        <!-- Book Cover --> 
        <div class="book-cover col-sm-4 col-sm-push-7">
            <img src='<?php echo $book_recommendations['book_image']; ?>'>
        </div>

        <!-- Book Presentation --> 
        <div class="col-sm-6 col-sm-pull-4 col-sm-offset-1">

            <h1><?php echo $book_recommendations['book_title']; ?></h1>

            <?php if( $book_recommendations['book_author'] != ' ') : ?>
                <h2>de<?php echo ' ' . $book_recommendations['book_author']; ?></h2>
            <?php endif ?>

            <?php if ( $book_recommendations['book_summary'] ) : ?>
                <div><?php echo $book_recommendations['book_summary']; ?></div>
            <?php endif; ?>

            <div class="book-info row">
                <em class="col-md-4">
                    <?php if( $book_recommendations['book_genre'] ) : ?>
                        Genre :<?php echo ' ' . $book_recommendations['book_genre']; ?>
                    <?php endif; ?>
                </em>

                <em class="col-md-4">
                    <?php if( $book_recommendations['book_theme'] ) : ?>
                        Theme :<?php echo ' ' . $book_recommendations['book_theme']; ?>
                    <?php endif; ?>
                </em>

                <em class="col-md-4">
                    <?php if( $book_recommendations['book_rewards'] ) : ?>
                        Prix Littéraires :<?php echo ' ' . $book_recommendations['book_rewards'];  ?>
                    <?php endif; ?>
                </em>
            </div>
            
            <!-- Book Affiliation -->  
            <?php get_affiliation_dropdown( $book_recommendations['book_affiliation'] ); ?>

        </div>

    </header>

    <!-- Book Recommendations Section --> 
    <?php if ( $num_recommendations > 0 ) : ?>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">

                <h2>
                    <?php if( $num_recommendations == 1 ) : ?>
                        Une personnalité recommande
                    <?php else : ?>
                        <?php echo $num_recommendations . ' '; ?>personnalités recommandent
                    <?php endif; ?>
                    <?php echo ' ' . $book_recommendations['book_title']; ?>
                </h2>

                <ul>
                    <?php foreach ($book_recommendations['recommendations'] as $recommendation) : ?>
                            
                        <li class="book-recommendation row">

                            <!-- Recommender Portait --> 
                            <div class="col-sm-3 recommender-portrait">
                                <a href="<?php echo $recommendation['person_url']; ?>">
                                    <img src="<?php echo $recommendation['person_image']; ?>" alt="<?php echo $person_name; ?>"/>
                                    <p><?php echo $recommendation['person_name']; ?></p>
                                </a>
                            </div>

                            <!-- Recommendation Text --> 
                            <div class="col-sm-9">
                                <a href="<?php echo $recommendation['person_url']; ?>">
                                    <h3><?php echo $recommendation['person_name']; ?></h3>
                                    <h4><?php echo ' - ' . $recommendation['person_introduction'] . ' - '; ?></h4>
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
wp_reset_query();



//........................................................................
// HEADER SECTION
//........................................................................

get_footer(); ?>


