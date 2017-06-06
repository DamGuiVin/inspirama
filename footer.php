<footer class="full-width-container primary-footer">
    <div class="container">
        <div class="row fat-footer" >
            <div class="column1 col-md-4" > <!-- beginning column1-->
                    <a href="<?php echo home_url( '/' ); ?>">
                    <img class="logo-uploaded" style="max-width:<?php echo esc_attr( get_theme_mod( 'themeora-img-upload-logo-width', '200' ) ); ?>px" src="<?php echo esc_url( get_theme_mod( 'themeora-img-upload-logo' ) );?>" alt="<?php the_title(); ?>" />
                    </a>  
                    <p></p>
                    <p class="about"><label> Yeswekant.com est une librairie en ligne. Découvrez sur ce site les livres qui ont marqué les personnalités qui vous inspirent. </label></p>
            </div>
            
            <?php if ( is_active_sidebar( 'footer-widget' ) ) : ?>
                <div id="widget-area" class="widget-area col-md-4">
                <i class="fa fa-envelope fa-3x"></i> 
                </br>
                <p>
                <label> Nous contacter </label>
                </br>
                Des remarques, des commentaires ?
                contact@yeswekant.com
                <?php dynamic_sidebar( 'footer-widget' ); ?>
                </div><!-- .widget-area -->
            <?php endif; ?>
            <div class="column3 col-md-4" > <!-- beginning column1-->
                    <i class="fa fa-telegram fa-3x"></i> 
                    </br>
                    <p>
                    <label>Toutes les semaines, de nouvelles recommendations :</label>
                    <input class="news" type="email" name="EMAIL" placeholder="Mon mail " required />
                    </br>
                    <input type="submit" value="Je m'inscris"/>
                    </p>
            </div>
        
        </div><!-- end row -->

        <div >
<p>© 2017 - YesWeKant | Home | Mentions légales | <a class="about" href="http://localhost/current/index.php/a-propos/">À propos</a> | Utilisation des cookies | Plan du site </p>
            </div>
        
        <?php if ( has_nav_menu( 'social_menu' ) ) : ?>
            <div class="row">
                <nav id="social-navigation" class="social-navigation" role="navigation">
                    <?php
                        // Social links navigation menu.
                        wp_nav_menu( array(
                            'theme_location' => 'social_menu',
                            'depth'          => 1,
                            'link_before'    => '<span class="screen-reader-text">',
                            'link_after'     => '</span>',
                        ) );
                    ?>
                </nav><!-- .social-navigation -->
            </div>
        <?php endif; ?>
        
        <div class="row footer-bottom">
            <?php
            $footer_text = '&copy; ' . date("Y") . ' <a href="' . esc_url( home_url() ) . '">' . get_bloginfo( 'name' ) . '</a>';
            $footer_text .= '<span class="sep"> | </span>';
            $footer_text .= get_bloginfo( "description" ); ?>
        </div>
        
    </div><!-- end container -->
</footer><!-- end full-width-container -->

    
</div><!-- end page wrapper -->

<?php wp_footer(); ?>

</body>
</html>