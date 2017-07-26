<!DOCTYPE html >

<!--[if lt IE 7 ]> <html class="no-js ie6" <?php language_attributes(); ?>> <![endif]-->

<!--[if IE 7 ]>    <html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->

<!--[if IE 8 ]>    <html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->

<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->



<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />  







    <!-- Hotjar Tracking Code for www.inspirama.co -->



    <!--<script>



        (function(h,o,t,j,a,r){

            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};

            h._hjSettings={hjid:539732,hjsv:5};

            a=o.getElementsByTagName('head')[0];

            r=o.createElement('script');r.async=1;

            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;

            a.appendChild(r);

        })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');



    </script>-->

    

    <!-- End Hotjar Tracking Code for www.inspirama.co -->







    <!-- Google Analytics Tracking Code for www.inspirama.co -->



    <script>



        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');



        ga('create', 'UA-102775935-1', 'auto');

        ga('send', 'pageview');

        

    </script>



    <!-- End Google Analytics Tracking Code for www.inspirama.co -->



    <!-- Google Suite Tracking Code for www.inspirama.co -->

    <meta name="google-site-verification" content="Vzc8nFFP9VcKYdqrlRngLMUmP2shcv7z52S7uL0TUbc" />

    <!-- End Google Suite Tracking Code for www.inspirama.co -->



    <!-- Opinion Stage Tracking Code for www.inspirama.co -->

    <script type="text/javascript">

        window.AutoEngageSettings = {"id":"3586408"};
        (function(d, s, id){
        var js,
            fjs = d.getElementsByTagName(s)[0],
            r = Math.floor(new Date().getTime() / 1000000);
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id; js.async=1;
        js.src = 'https://www.opinionstage.com/assets/autoengage.js?' + r;
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'os-jssdk'));

    </script>

    <!-- End Opinion Stage Tracking Code for www.inspirama.co -->



    <!-- JS code for automatic smooth scrolling to anchor links -->



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript">



        $(document).ready(function(){

          // Add smooth scrolling to all links

          $("a").on('click', function(event) {



            // Make sure this.hash has a value before overriding default behavior

            if (this.hash !== "") {

                // Prevent default anchor click behavior

                event.preventDefault();



                // Store hash

                var hash = this.hash;



                // Using jQuery's animate() method to add smooth page scroll

                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area

                $('html, body').animate({

                scrollTop: $(hash).offset().top

                }, 800, function(){



                // Add hash (#) to URL when done scrolling (default click behavior)

                window.location.hash = hash;

                });

            } // End if

          });

        });



    </script>



    <!-- End JS code for automatic smooth scrolling to anchor links -->







    <!-- JS code for Typed cursor function -->



    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() . '/js/dist/typed.min.js' ; ?>"></script>



    <?php $list_names_php = get_all_people_names(); ?>



    <script type="text/javascript">



        $(function(){



            var list_names = <?php echo json_encode($list_names_php); ?>;



            $(".element").typed({

                strings: list_names,

                typeSpeed: 100,

                backDelay: 1000,

                loop: true

            });

        });



    </script>



    <!-- End JS code for Typed cursor function -->

    





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

          

                



                    <a href="<?php echo home_url(); ?>">



                        <img class="logo-uploaded" style="max-width:<?php echo esc_attr( get_theme_mod( 'themeora-img-upload-logo-width', '200' ) ); ?>px" src="<?php echo esc_url( get_theme_mod( 'themeora-img-upload-logo' ) );?>" alt="<?php the_title(); ?>" />

                    </a>



                <?php } else { ?>

                    <h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

                <?php }



                if ( get_theme_mod( 'themeora-show-description-header' ) == 'Yes' ) : ?>

                    <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>

                <?php endif; ?>



                <!--End Logo Section -->



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



                        <a href="<?php echo get_site_url() . '/a-propos/'; ?>">À propos</a>



                    </li>

                <!--End A propos -->



                <!--Beginning Search -->



                    <li class="search-bar-menu">

             

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



