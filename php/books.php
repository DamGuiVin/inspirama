<?php 

//.......................................................................................................
// Get the affiliation section of a book
//.......................................................................................................

function get_affiliation_dropdown( $affiliation_data ) {

    ?>
    <div class="dropdown inspirama-affiliation-dropdown">
        <button class="btn btn-basic dropdown-toggle" type="button" data-toggle="dropdown">
            Acheter<span class='glyphicon glyphicon-chevron-down'></span>
        </button>
        <ul class="dropdown-menu">

            <?php foreach ( $affiliation_data as $brand ) : ?>
                <li>
                    <a target="_blank" href="<?php echo $brand[1]; ?>" title="<?php echo $brand[0]; ?>" >
                        <img class="social-media-icon" src="<?php echo $brand[2]; ?>" alt="<?php echo $brand[0]; ?>" />
                    </a>
                </li>
            <?php endforeach; ?>

        </ul>
    </div>
    <?php
}


?>