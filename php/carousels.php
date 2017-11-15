<?php 

//.......................................................................................................
// Recommendation Carousel : Building an individual slide of the recomendation carousel 
//.......................................................................................................

function recommendations_carousel_item ( $book_reco_array, $max_people_per_book = 3 ) {

    ?>
    <div class='container-fluid'>
        <div class='row'>
            <div class='hp-recommendations col-xs-10 col-xs-offset-1'>

                <!-- Book Section -->
                <div class='recommended-book col-xs-4'>
                    <a href='<?php echo $book_reco_array['book_url']; ?>'>
                        <img class='img-adapt' src='<?php echo $book_reco_array['book_image']; ?>'>
                    </a>                    
                    <h3 class='one-line-ellipsis'><?php echo $book_reco_array['book_title']; ?></h3>
                    <h4 class='one-line-ellipsis'><?php echo $book_reco_array['book_author']; ?></h4>
                </div>

                <!-- Recommendations and People Section -->
                <div class='list-recommendations col-xs-8'>
                    <ul>
                        <?php foreach ( $book_reco_array['recommendations'] as $i => $one_person_recommendation ) : ?>
                            <?php if ( $i < $max_people_per_book ) : ?>
                                <li>
                                    <div class='one-recommendation'>
                                        <blockquote class='quote'><?php echo $one_person_recommendation['text']; ?></blockquote>
                                        <h3 class='one-line-ellipsis'><?php echo $one_person_recommendation['person_name']; ?></h3>
                                        <a href='<?php echo $one_person_recommendation['person_url']; ?>'>
                                            <img class='img-adapt' src='<?php echo $one_person_recommendation['person_image']; ?>'>
                                        </a>
                                    </div>
                                </li>
                            <?php endif ?>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
}

//.......................................................................................................
// Recommendation Carousel : Building the carousel structure
//.......................................................................................................

function recommendations_carousel ( $books_slugs_array ) {

    $top_recommendations = get_top_recommendations( $books_slugs_array );
    
    if ( !empty( $top_recommendations )) : ?>

        <!-- Top Recommendations Carousel -->
        <div id="recommandations-populaires" class="carousel slide" data-ride="carousel" data-interval="10000">
            
            <h2>Les recommandations populaires</h2>

            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#recommandations-populaires" data-slide-to="0" class="active"></li>
                <?php for ( $i = 1; $i < count( $top_recommendations ); $i++ ) : ?>
                    <li data-target="#recommandations-populaires" data-slide-to="<?php echo $i; ?>"></li>
                <?php endfor ?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">

                <?php foreach ( $top_recommendations as $i => $book_reco_array) : ?>
                    <?php if ( $i == 0 ) : ?>

                        <div class="item active">
                            <?php recommendations_carousel_item( $book_reco_array ); ?>
                        </div>

                    <?php else : ?>

                        <div class="item">
                            <?php recommendations_carousel_item( $book_reco_array ); ?>
                        </div>

                    <?php endif ?>  
                <?php endforeach ?> 
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#recommandations-populaires" data-slide="prev">
                <div class="glyphicon glyphicon-chevron-left"></div>
                <span class="sr-only">Précédent</span>
            </a>
            <a class="right carousel-control" href="#recommandations-populaires" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Suivant</span>
            </a>

        </div>
    <?php endif;

}

//.......................................................................................................
// Books Carousel : Building an individual slide of the carousel
//.......................................................................................................

function books_carousel_item( $books_batch ) {

    ?>
    <div class='container-fluid'>
        <div class='row'>
            <div class='top-books col-xs-10 col-xs-offset-1'>
                <ul class='list-books'>
                    <?php foreach ( $books_batch as $book ) : ?>
                        <li>
                            <div class='recommended-book'>
                                <a href='<?php echo $book['book_url']; ?>'>
                                    <img class='img-adapt' src='<?php echo $book['book_image']; ?>'>
                                </a>                    
                                <h3 class='one-line-ellipsis'><?php echo $book['book_title']; ?></h3>
                                <h4 class='one-line-ellipsis'><?php echo $book['book_author']; ?></h4>
                            </div>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
    <?php

}

//.......................................................................................................
// Books Carousel : Building the carousel structure
//.......................................................................................................

function books_carousel() {

    $top_books = get_top_books();
    
    if ( !empty( $top_books )) : ?>

        <!-- Top Books Carousel -->
        <div id='livres-populaires' class='carousel slide' data-ride='carousel' data-interval='10000'>
            
            <!-- Indicators -->
            <ol class='carousel-indicators'>
                <li data-target='#livres-populaires' data-slide-to='0' class='active'></li>
                <?php for ( $i = 1; $i < count( $top_books ); $i++ ) : ?>
                    <li data-target='#livres-populaires' data-slide-to='<?php echo $i; ?>'></li>
                <?php endfor ?>
            </ol>

            <!-- Wrapper for slides -->
            <div class='carousel-inner'>

                <?php foreach ( $top_books as $i => $books_batch ) : ?>
                    <?php if ( $i == 0 ) : ?>

                        <div class='item active'>
                            <?php books_carousel_item( $books_batch ); ?>
                        </div>

                    <?php else : ?>

                        <div class='item'>
                            <?php books_carousel_item( $books_batch ); ?>
                        </div>

                    <?php endif ?>  
                <?php endforeach ?> 
            </div>

            <!-- Left and right controls -->
            <a class='left carousel-control' href='#livres-populaires' data-slide='prev'>
                <div class='glyphicon glyphicon-chevron-left'></div>
                <span class='sr-only'>Précédent</span>
            </a>
            <a class='right carousel-control' href='#livres-populaires' data-slide='next'>
                <span class='glyphicon glyphicon-chevron-right'></span>
                <span class='sr-only'>Suivant</span>
            </a>

             <!-- Loading image -->
            <div id="loading-image" class="top-books col-xs-10 col-xs-offset-1">
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/ajax_loader_book.gif'; ?>"/>
            </div>

        </div>
    <?php endif;
}

//.......................................................................................................
// Books Carousel : AJAX call for updating the carousel to the selected category
//.......................................................................................................

add_action( 'wp_ajax_inspirama_get_books_carousel', 'inspirama_get_books_carousel' );
add_action( 'wp_ajax_nopriv_inspirama_get_books_carousel', 'inspirama_get_books_carousel' );

function inspirama_get_books_carousel() {

    $category_name = $_POST['category_name'];

    $selected_books = get_top_books( $category_name );

    $response['selected_books'] = $selected_books;
    $response['error'] = 'The server could not retrieve the required data';
    
    wp_send_json( $response );
}


?>