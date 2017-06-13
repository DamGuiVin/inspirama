<footer class="full-width-container primary-footer">
    <div class="container">
        <div class="row fat-footer" >
            
            <div class="column1 col-md-4" > <!-- beginning column1-->
                    <a href="<?php echo home_url( '/' ); ?>">
                        <img class="logo-uploaded" style="max-width:<?php echo esc_attr( get_theme_mod( 'themeora-img-upload-logo-width', '200' ) ); ?>px" src="<?php echo esc_url( get_theme_mod( 'themeora-img-upload-logo' ) );?>" alt="<?php the_title(); ?>" />
                    </a>
                    <br>
                    <h5 class="about" style="strong"> Yeswekant.com est une librairie en ligne. Découvrez sur ce site les livres qui ont marqué les personnalités qui vous inspirent.</h5>
            </div>

            <div class="emailpage">
                <?php if ( is_active_sidebar( 'footer-widget' ) ) : ?>
                    
                    <div id="widget-area" class="widget-area col-md-4">
                        <img src="http://localhost/current/wp-content/uploads/2017/06/mail1.png" height="50" width="50" class="mail-icon" alt="Mail">
                            <br>
                            <h5> Une remarque, un commentaire ? <br><br> contact@yeswekant.com </h5>
                        <?php dynamic_sidebar( 'footer-widget' ); ?>
                    </div><!-- .widget-area -->

            <?php endif; ?>
            </div>
            
            <div class="column3 col-md-4" > <!-- beginning column1-->
                    <img src="http://localhost/current/wp-content/uploads/2017/06/paperplane1.png" height="40" width="40" class="newsletter-icon" alt="Mail">
                    <br>
                    <h5>Chaque semaine, je reçois les conseils d'une personnalité :</h5>
                    <input class="news" type="email" name="EMAIL" placeholder="Mon mail " required />
                    <br>
                    <input type="submit" value="Je m'inscris"/>
            </div>
        
        </div><!-- end row -->

        <div >
            <hr>
            <p>© 2017 - YesWeKant | <a class="about" href="http://localhost/current/index.php">Home</a> | <a class="about" href="http://localhost/current/index.php/contact/">Contact</a> | <a class="about" href="http://localhost/current/index.php/a-propos/">À propos</a></p>
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