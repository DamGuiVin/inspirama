<?php 

get_header();

    // Get theme options

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

                        <br>

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

<!-- begin to show search answers -->


<?php if ( have_posts() ) : ?>


<div class="full-width-container main-content-area">

    <div class="container">

        <div class="row">

            <hr>

                <?php if ( have_posts() ) : ?>

                    <div id="posts-wrapper">

                        <?php while ( have_posts() ) : the_post(); ?>

                            <div class="row result">  

                                <div class="col-md-4">

                                    <a href="<?php echo the_permalink(); ?>"><?php if ( has_post_thumbnail() ) {
                                    the_post_thumbnail( array(150,800) );
                                    } ?></a>

                                </div>

                                <div class="col-md-4 search-text">

                                    <h2 class="search-title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h2>

                                    <h5><a class="search-excerpt" href="<?php echo the_permalink(); ?>"><?php the_excerpt(); ?></a></h5>

                                    <br>

                                </div>

                            </div>

                            <hr>

                        <?php endwhile; ?>

                    </div>

                <?php endif; ?>

        </div><!-- row -->

    </div><!-- container -->

</div>
   

<?php else : ?>

    <div class="container">

        <div class="row">

            <div class="col-md-10 col-md-offset-1 text-center">

                <?php if ( ! have_posts() ) : ?>

                    <p>
                        Désolé ! Nous n'avons trouvé aucun résultat pour <strong>'<?php the_search_query() ?>'</strong>. 
                        <br>Peut-être voulez-vous rechercher autre chose ?
                    </p>

                    <br>

                    <?php get_search_form(); ?>

                <?php endif; ?>

            </div><!-- col-md-10 -->

        </div><!-- end row -->

    </div><!-- end container -->

<?php endif; ?>



<?php get_footer(); ?>