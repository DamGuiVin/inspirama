<?php 

//.......................................................................................................
// Get the 'library' of a person page
//.......................................................................................................

function get_person_library() {
    ?>

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
    
    <?php
}



?>