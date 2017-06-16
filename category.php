<?php 

//........................................................................
// HEADER SECTION
//........................................................................

get_header();



//........................................................................
// CATEGORY PRESENTATION SECTION
//........................................................................

// Getting necessary category variables
$category_name = single_cat_title('', false);
//$category_description = category_description();

// Get the category's background image
$background_image = z_taxonomy_image_url($current_category->term_id); ?>

<!-- Category Presentation -->
<header class=  "full-width-container-category center-page welcome-screen <?php $background_image != '' ? print 'header-with-background' : '' ?> <?php has_excerpt() ? print 'header-with-excerpt ' : print 'header-without-excerpt'; ?>" role="banner" data-welcome-background="<?php echo $background_image; ?>" >
    <div class="container welcome-container-category">
        <div class="row welcome-row">
            <div class="col-md-10 col-md-offset-1">
                <h1 class=""><?php echo $category_name ?></h1>
                <!-- <h2 class=''><?php echo $category_description ?></h2> -->
            </div>
        </div>
    </div>
</header>
<!-- End Category Presentation -->
<?php



//........................................................................
// CATEGORY'S PERSONS SECTION : RECOVERING PERSONS
//........................................................................

// Clearing any previous query
wp_reset_query(); 

// Building the arguments for the WP Query to get the Person pages in the current Category
$args = array(
    'post_type' => 'person',
    'post_status' => 'publish',
    'tax_query' => array(
            array(
            'taxonomy' => 'category',
            'field'    => 'name',
            'terms'    => $category_name,
        ),
    ),
);

// Sending the WP_Query
$wp_query = new WP_Query( $args );

// Setting the person preview image size 
$img_size = 'themeora-portfolio-span-8';



//........................................................................
// CATEGORY'S PERSONS SECTION : PERSONS MOSAIC
//........................................................................

if ( $wp_query->have_posts() ) : ?>
    
    <!-- Persons Mosaic -->  
    <ul id="masonry-wrapper" class="portfolio-cols-4">
        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post();

            // Recover useful attributes from the Person
            $person_page_id = $wp_query->post->ID;
            $person_name = get_the_title();
            $person_intoduction = get_post_meta( $person_page_id, 'introduction', true);

            // Check if the portfolio has an image. Only load the item if it does
            if ( has_post_thumbnail( $person_page_id ) ) :
                $previewImage = wp_get_attachment_image_src( get_post_thumbnail_id( $person_page_id ), $img_size ); ?>
                <li class="masonry-item">
                    <div class="person">
                        <a href="<?php echo the_permalink($person_page_id); ?>" class="portfolio-link">
                            <img src="<?php echo $previewImage[0] ?>" class="img-adapt" alt="<?php echo $person_name; ?>" />
                            <div class="portfolio-details">
                                <div class="details-person-name">
                                    <h2 class="details-person-name"><?php echo $person_name; ?></h2>
                                </div>
                                <div class="details-person-introduction">
                                    <?php if ( $person_intoduction ) : ?>
                                        <h4><?php echo $person_intoduction; ?></h4>
                                    <?php endif; ?>
                                </div>
                                <div class="details-person-invitation">
                                    <h4>Découvrez ses recommandations de lecture</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </li>
            <?php endif; ?>
        <?php endwhile; ?>
    </ul>
    <!-- End Persons Mosaic -->  

<?php 
wp_reset_query();
endif; 



//........................................................................
// FOOTER SECTION 
//........................................................................

get_footer(); ?>