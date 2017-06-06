<?php



$form = '<form method="get" class="search-form" action="' . esc_url(home_url('/')) . '">

<input type="text" name="s" placeholder="' . esc_attr_x('Rechercher', 'Site search', 'oren' ) . '" value="' . get_search_query() . '"  />

</form>';



echo $form;

?>