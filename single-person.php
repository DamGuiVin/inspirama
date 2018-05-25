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
                        <?php echo $num_recommendations . ' '; ?>livres recommandés par
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
// FOOTER SECTION 
//........................................................................

get_footer(); ?>