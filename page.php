<?php 

//........................................................................
// HEADER SECTION
//........................................................................

get_header();



//........................................................................
// PAGE SECTION
//........................................................................
?>

<!-- Page Presentation -->
<header class="full-width-container-category center-page welcome-screen">
    <div class="container welcome-container-category">
        <div class="row welcome-row">
            <div class="col-xs-10 col-xs-offset-1">
                <h1 class="category-title"><?php the_title(); ?></h1>
            </div>
        </div>
    </div>
</header>
<!-- End Page Presentation -->


<!-- Page Content -->
<div class="container default-page-content">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2">
            <?php if ( have_posts() ) :
                while ( have_posts() ) : the_post(); 
                    the_content();
                endwhile;
            else :
                _e('Désolé, la page est introuvable !', 'oren');
            endif; ?>
        </div>
    </div>
</div>
<!-- End Page Content -->





<?php
//........................................................................
// FOOTER SECTION 
//........................................................................

get_footer(); ?>