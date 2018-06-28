<?php
/* ===============================================
	SEARCH FORM
	Skin - Premium WordPress Theme, by NordWood
================================================== */
	$search_placeholder = get_theme_mod( 'skin_search_placeholder', esc_attr__( 'Type your search', 'skin' ) );
?>
<form role="search" autocomplete="off" method="get" class="search-form clearfix" action="<?php echo esc_url( home_url( '/' ) ); ?>">		
	<input type="search" class="search-field"
		name="s"
		title="<?php echo esc_attr( $search_placeholder ); ?>"
		placeholder="<?php echo esc_attr( $search_placeholder ); ?>"
		value="<?php echo get_search_query(); ?>"
	/>
	<button type="submit" class="search-submit va-middle txt-color-to-svg"><?php echo skin_get_icon_search(); ?></button>
</form>