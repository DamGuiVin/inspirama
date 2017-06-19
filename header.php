<!DOCTYPE html >
<!--[if lt IE 7 ]> <html class="no-js ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="http://localhost/current/wp-content/themes/oren_child/js/dist/typed.min.js"></script>
    <script>

        $(function(){
          $(".element").typed({
            strings: [" STEVE JOBS", " VLADIMIR POUTINE", " STALINE", " NICOLAS SARKOZY" ],
            typeSpeed: 100,
            backDelay: 1000,
            loop: true
          });
        });
    </script>

    <style type="text/css"> html {scroll-behavior: smooth;} </style>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <!--[if lt IE 9]>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/respond.js"></script>
    <![endif]-->

    <?php wp_head(); ?>
</head>


<!-- Appel des polices utilisees : TEMPORAIRE. Sauvegarde dans notre base a plus long terme -->
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab|Source+Sans+Pro|Gidugu|Oswald|Raleway|Lato" rel="stylesheet">

<!-- Appel du catalogue d'icones AwesomeFonts : TEMPORAIRE. Sauvegarde dans notre base a plus long terme -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body <?php body_class(); ?>>


<div class="page-wrapper" data-scroll-speed="500">
    
  <!-- BEGIN NAV -->
  
    <nav class="primary-navigation navbar" role="navigation">
        <div class="container">
          
            <div class="navbar-header">

                <div class="hamburger">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">

                        <span class="menu-text sr-only"><?php _e('Menu', 'oren'); ?></span>

                        <span class="fa fa-bars"></span>

                    </button>

                </div>
          
                <!-- Logo Section -->

                <?php if ( get_theme_mod( 'themeora-img-upload-logo' ) ) { ?>
          
                <!--End Logo Section -->

                    <a href="<?php echo home_url( '#masonry-wrapper' ); ?>">

                        <img class="logo-uploaded" style="max-width:<?php echo esc_attr( get_theme_mod( 'themeora-img-upload-logo-width', '200' ) ); ?>px" src="<?php echo esc_url( get_theme_mod( 'themeora-img-upload-logo' ) );?>" alt="<?php the_title(); ?>" />
                    </a>

                <?php } else { ?>
                    <h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php }

                if ( get_theme_mod( 'themeora-show-description-header' ) == 'Yes' ) : ?>
                    <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
                <?php endif; ?>

            </div><!-- end navbar-header -->

            <div class="navbar-collapse collapse" id="nav-spy" style="padding: <?php echo esc_html( get_theme_mod('themeora-img-upload-logo-padding', '0') ) ?>px 0px;">
                <!-- Navigation Menu -->
                <div class="nav-wrap">
                    <?php if ( has_nav_menu('primary_menu') ) {
                        wp_nav_menu(array(
                        'container' =>false,
                        'theme_location' => 'primary_menu',
                        'menu_class' => 'nav navbar-nav',
                        'echo' => true,
                        'before' => '',
                        'after' => '',
                        'link_before' => '',
                        'link_after' => '',
                        'depth' => 0,
                        'walker' => new themeora_Walker_Nav_Menu()
                        )); 
                    } ?>
                </div>
                <!--End Navigation Menu -->
              
                <ul class="menu-right"> 

                <!--Beginning A propos -->
                    <li class="top-menu">

                        <a href="http://localhost/current/index.php/a-propos/">Qui sommes nous ?</a>

                    </li>
                <!--End A propos -->

                <!--Beginning Search -->

                    <li class="search-bar-menu">

                        <img class="search-icon" src="http://localhost/current/wp-content/uploads/2017/06/search.png" height="24" width="24" class="search-icon" alt="Search-icon"> 
             
                        <div class="search-form-menu">

                            <?php get_search_form(); ?> 

                        </div> 

                    </li>

                <!--End search -->

                </ul>   
                    
            </div><!-- end .navbar-collapse #nav-spy -->

        </div>
    </nav>
    <!-- END NAV -->

