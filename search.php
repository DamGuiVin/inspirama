<?php 

get_header();

?>



<header class="full-width-container no-bottom-padding" role="banner">

    <div class="container">

            <h1 class="archive-title no-bottom-margin">

                <span>

                    <!-- search title -->

                    <?php if ( is_search() ) :	?>

                        <p>

                        <?php _e('Résultats de recherche pour', 'oren'); ?> 

                        '<?php the_search_query() ?>'

                        </p>

                    <?php endif; ?>


                    <!-- tag title -->


                    <?php if ( is_tag() ) : ?>

                        <?php single_tag_title(); ?>

                    <?php endif; ?>


                    <!-- category title -->

                    <?php if ( is_category() ) :	?>

                        <?php single_cat_title(); ?>

                    <?php endif; ?>

                </span>

            </h1>

    </div><!-- end container -->

</header>





<?php

$layout = get_theme_mod('themeora_blog_layout', 'full-width');

?>



<?php if ( have_posts() ) : ?>

    

    <?php get_template_part( 'template-search' ); ?>

   

<?php else : ?>

    <div class="container">

        <div class="row">

            <div class="col-md-10 col-md-offset-1 text-center">

                <?php if ( ! have_posts() ) : ?>

                    <p>

                    <?php _e('Désolé ! Nous n\'avons trouvé aucun résutat. Peut être voulez-vous rechercher autre chose ?' , 'oren'); ?>

                    </p>

                    <br>

                    <?php get_search_form(); ?>

                <?php endif; ?>

            </div><!-- col-md-10 -->

        </div><!-- end row -->

    </div><!-- end container -->

<?php endif; ?>



<?php get_footer(); ?>