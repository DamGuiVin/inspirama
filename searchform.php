<form method="get" class="inspirama-open-search" action="<?php echo esc_url(home_url('/')); ?>" >

	<input type="text" class="inspirama-round-button" name="s" placeholder="<?php echo esc_attr_x('Chercher une personne, un livre...', 'Site search', 'oren' ); ?>" value="<?php echo get_search_query(); ?>" />
	<input type="image" class="inspirama-round-button" name="s" src="<?php echo get_stylesheet_directory_uri() . '/img/search.png'; ?>" />

</form>