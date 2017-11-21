<?php 

//.......................................................................................................
// Get the affiliation section of a book
//.......................................................................................................

function get_book_affiliation( $book_page_id ) {

    $affiliation_data = get_affiliation_data( $book_page_id ); ?>

    <div class="book-affiliation">
        <p>Acheter</p>

        <?php if ( $affiliation_data[ 'amazon_logo' ] && $affiliation_data[ 'amazon_url' ] ) : ?> 
            <a target="_blank" href="<?php echo $affiliation_data[ 'amazon_url' ]; ?>" title="Amazon">
                <img class="social-media-icon" src="<?php echo $affiliation_data[ 'amazon_logo' ]; ?>" alt="" />
            </a>
        <?php endif;

        if ( $affiliation_data[ 'leslibraires_logo' ] && $affiliation_data[ 'leslibraires_url' ] ) : ?>
            <a target="_blank" href="<?php echo $affiliation_data[ 'leslibraires_url' ]; ?>" title="Les Libraires">
                <img class="social-media-icon" src="<?php echo $affiliation_data[ 'leslibraires_logo' ]; ?>" alt="" />
            </a>
        <?php endif;

        if ( $affiliation_data[ 'fnac_logo' ] && $affiliation_data[ 'fnac_url' ] ) : ?>
            <a target="_blank" href="<?php echo $affiliation_data[ 'fnac_url' ]; ?>" title="La Fnac">
                <img class="social-media-icon" src="<?php echo $affiliation_data[ 'fnac_logo' ]; ?>" alt="" />
            </a>
        <?php endif;

        if ( $affiliation_data[ 'priceminister_url' ] && $affiliation_data[ 'priceminister_logo' ] ) : ?>
            <a target="_blank" href="<?php echo $affiliation_data[ 'priceminister_url' ]; ?>" title="PriceMinister">
                <img class="social-media-icon" src="<?php echo $affiliation_data[ 'priceminister_logo' ]; ?>" alt="" />
            </a>
        <?php endif;

        if ( $affiliation_data[ 'recyclivre_url' ] && $affiliation_data[ 'recyclivre_logo' ] ) : ?>
            <a target="_blank" href="<?php echo $affiliation_data[ 'recyclivre_url' ]; ?>" title="RecycLivre">
                <img class="social-media-icon" src="<?php echo $affiliation_data[ 'recyclivre_logo' ]; ?>" alt="" />
            </a>
        <?php endif;

        if ( $affiliation_data[ 'ebook_url' ] && $affiliation_data[ 'ebook_logo' ] ) : ?>
            <a target="_blank" href="<?php echo $affiliation_data[ 'ebook_url' ]; ?>" title="EBook">
                <img class="social-media-icon" src="<?php echo $affiliation_data[ 'ebook_logo' ]; ?>" alt="" height="64" width="90"/>
            </a>
        <?php endif;

        if ( $affiliation_data[ 'gutenberg_url' ] && $affiliation_data[ 'gutenberg_logo' ] ) : ?>
            <a target="_blank" href="<?php echo $affiliation_data[ 'gutenberg_url' ]; ?>" title="Gutenberg Project">
                <img class="social-media-icon" src="<?php echo $affiliation_data[ 'gutenberg_logo' ]; ?>" alt="" />
            </a>
        <?php endif; ?>
    </div>

    <?php
}

?>