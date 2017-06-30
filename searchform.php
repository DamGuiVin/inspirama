<?php

$form = '<form method="get" class="search-form-menu" action="' . esc_url(home_url('/')) . '">

<div class="search-form-inline-container">
	<input class="search-form glowing-border" type="text" name="s" placeholder="' . esc_attr_x('Rechercher', 'Site search', 'oren' ) . '" value="' . get_search_query() . '"  />
</div>

<div class="search-form-inline-container">
	<input class="search-icon" type="image" src="' . get_stylesheet_directory_uri() . '/img/search.png' . '" height="25" width="25" name="s"/>
</div>

</form>';

echo $form;

?>