<!DOCTYPE html >

<!--[if lt IE 7 ]> <html class="no-js ie6" <?php language_attributes(); ?>> <![endif]-->

<!--[if IE 7 ]>    <html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->

<!--[if IE 8 ]>    <html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->

<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->



<!-- Hotjar Tracking Code for www.inspirama.co -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:539732,hjsv:5};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
</script>
<!-- End Hotjar Tracking Code for www.inspirama.co -->



<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />  

    <!-- Google Suite Tracking Code for www.inspirama.co -->
    <meta name="google-site-verification" content="Vzc8nFFP9VcKYdqrlRngLMUmP2shcv7z52S7uL0TUbc" />  

    <link rel="alternate" href="https://www.inspirama.co<?php echo parse_url($_SERVER[‘REQUEST_URI’],PHP_URL_PATH); ?>" hreflang="fr" />
    
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <!-- Appel des polices utilisees : TEMPORAIRE. Sauvegarde dans notre base a plus long terme -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab|Source+Sans+Pro|Gidugu|Oswald|Raleway|Lato">

    <!--[if lt IE 9]>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5shiv.min.js"></script>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/respond.js"></script>
    <![endif]-->

    <link rel="stylesheet" id="parent-style-css" href="<?php echo get_template_directory_uri() . '/style.css'; ?>" type="text/css" media="">
    <link rel="stylesheet" id="child-style-css" href="<?php echo get_stylesheet_directory_uri() . '/style.css'; ?>" type="text/css" media="">

    <?php wp_head(); ?>

</head>







<body <?php body_class(); ?>>
<div class="page-wrapper" data-scroll-speed="500">   









    <!-- Navigation Bar -->
    <nav id="navigation-bar" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">

            <!-- Logo Section -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <?php if ( get_theme_mod( 'themeora-img-upload-logo' ) ) { ?>             
                    <a class="navbar-brand" href="<?php echo home_url(); ?>">
                        <img class="logo-inspirama" style="max-width:<?php echo esc_attr( get_theme_mod( 'themeora-img-upload-logo-width', '200' ) ); ?>px" src="<?php echo esc_url( get_theme_mod( 'themeora-img-upload-logo' ) );?>" alt="<?php the_title(); ?>" />
                    </a>
                <?php } ?>
            </div>
            <!--End Logo Section -->

            <div class="collapse navbar-collapse" id="myNavbar">
                <?php if ( has_nav_menu('primary_menu') ) {
                    wp_nav_menu( array(
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

                <ul class="nav navbar-nav navbar-right" id="myNavbar"> 

                    <!--Beginning Search -->
                    <li>           
                        <div class="search-form-menu">
                            <?php get_search_form(); ?> 
                        </div> 
                    </li>
                    <!--End search -->
                    
                    <!--Beginning A propos -->
                    <li id="navigation-about">
                        <a href="<?php echo get_site_url() . '/a-propos/'; ?>">À propos</a>
                    </li>
                    <!--End A propos -->

                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navigation Bar -->





