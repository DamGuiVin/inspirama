<?php

    /*

    * Template Name: Book

    */

get_header();
?>


<div class="full-width-container main-content-area">
    
    <div class="container">
        <div class="row">
            <div class="col-md-3 img-responsive center-block"><?php 
			if ( has_post_thumbnail() ) {
			the_post_thumbnail( array(800,3200) );
			}  ?>
			</div>
            	<div class="col-md-8">
            		<h1 class="booktitle">Titre du livre : <?php the_field('title'); ?> </br>
            	    Auteur : <?php the_field('author'); ?></h1>
            		<p class="summary"><b>Résumé du livre : </b><?php the_field('summary'); ?></p>
            		<p class="rec"><b>Recommandation de Steve : </b><?php the_field('rec'); ?></p>
            		<h4> ACHETER LE LIVRE SUR : </h4>
            	    <a href="<?php the_field('amazon'); ?>"> <img src="<?php the_field('buy1'); ?>" alt="" /> </a>
            	    <a href="<?php the_field('leslibraires'); ?>"> <img src="<?php the_field('buy2'); ?>" alt="" /> </a>
            	    <a href="<?php the_field('fnac'); ?>"> <img src="<?php the_field('buy3'); ?>" alt="" /> </a>
				</div>
            <?php the_content(); ?>
            <div class="content">
            </div> <!-- end row -->
        </div><!-- end container -->
</div><!-- end main-content-area -->


<?php get_footer(); ?>


