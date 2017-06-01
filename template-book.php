<?php

    /*

    * Template Name: Book

    */

get_header();
?>


<div class="full-width-container main-content-area">
    
    <div class="container">

        <div class="row">

            <div class="col-md-3 img-responsive center-block">

                <?php 

    			if ( has_post_thumbnail() ) {
    			the_post_thumbnail( array(800,3200) );
    			}  

    			$book_page_id = get_the_id();

    			$book_title = get_the_title();
    			$book_author = get_post_meta( $book_page_id, 'author', true);
    			$book_summary = get_post_meta( $book_page_id, 'summary', true);

    			$book_recommender = get_the_tags( $book_page_id )[0]->name;
    			$book_recommendation = get_post_meta( $book_page_id, 'recommendation', true);

    			$book_amazon_url = get_post_meta( $book_page_id, 'amazon_url', true);
    			$book_amazon_logo = get_post_meta( $book_page_id, 'amazon_logo', true);

    			$book_leslibraires_url = get_post_meta( $book_page_id, 'leslibraires_url', true);
    			$book_leslibraires_logo = get_post_meta( $book_page_id, 'leslibraires_logo', true);

    			$book_fnac_url = get_post_meta( $book_page_id, 'fnac_url', true);
    			$book_fnac_logo = get_post_meta( $book_page_id, 'fnac_logo', true);
    			
    			?>

            	<div class="col-md-8">

            		<h1 class="booktitle"><?php echo $book_title; ?></br>
            	    de <?php echo $book_author; ?></h1>
            		
            		<?php
            		if ( $book_summary ) : ?>
	            		<p class="summary"><b>Résumé : </b><?php echo $book_summary; ?></p>
	            	<?php 
                    else : ?>
                        <p class="summary"><b>Résumé : </b>Désolé, nous n'avons pas encore de résumé pour ce livre dans notre base de données.</p>
                    <?php 
	            	endif;
	            	
            		if ( $book_recommendation && $book_recommender ) : ?>	
            			<p class="rec"><b>Recommandation de <?php echo $book_recommender; ?> : </b><?php echo $book_recommendation; ?></p>
            		<?php 
                    else : ?>
                        <p class="rec"><b>Recommandation de <?php echo $book_recommender; ?>  : </b>Désolé, nous n'avons pas encore la recommandation de <?php echo $book_recommender; ?> pour ce livre dans notre base de données.</p>
                    <?php 
	            	endif; ?>

            		<h4> Acheter ce livre : </h4>
            	    
            	    <?php 
            	    if ( $book_amazon_logo && $book_amazon_url ) : ?>	
            	    	<a href="<?php echo $book_amazon_url; ?>" title="Amazon"> <img src="<?php echo $book_amazon_logo; ?>" alt="" /> </a>
            	    <?php 
            	    endif; ?>

            	    <?php 
            	    if ( $book_leslibraires_logo && $book_leslibraires_url ) : ?>
	            	    <a href="<?php echo $book_leslibraires_url; ?>" title="Les Libraires"> <img src="<?php echo $book_leslibraires_logo; ?>" alt="" /> </a>
            	    <?php 
            	    endif; ?>

            	    <?php 
            	    if ( $book_fnac_logo && $book_fnac_url ) : ?>
	            	    <a href="<?php echo $book_fnac_url; ?>" title="La Fnac"> <img src="<?php echo $book_fnac_logo; ?>" alt="" /> </a>
	            	<?php 
            	    endif; ?>

				</div>

            </div>

        </div><!-- end row -->

    </div><!-- end container -->

</div><!-- end main-content-area -->


<?php get_footer(); ?>


