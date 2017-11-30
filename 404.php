<?php get_header(); 

    // Get theme options

?>



<div class="full-width-container">

    <div class="container">

        <div class="row">

            <div class="col-md-10 col-md-offset-1 text-center">

                <?php if ( ! have_posts() ) : ?>

                    <h1 class="title"><?php _e('Désolé! La page que vous cherchez n\'existe pas.', 'oren'); ?></h1>

                    <br><br>

                    <p>
                        
                        <?php _e( 'Rechercher une autre page :', 'oren' ); ?>

                        <?php get_search_form(); ?>

                    </p>

                <?php endif; ?>

                <?php print_r( get_post_type_archive_link('recommendation')); ?>

            </div><!-- col-md-10 -->

        </div><!-- end row -->

    </div><!-- end container -->

</div><!-- end full-width-container -->



<?php get_footer(); ?>