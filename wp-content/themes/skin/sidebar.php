<?php
/* ===============================================
	SIDEBAR TEMPLATE
	Skin - Premium WordPress Theme, by NordWood
================================================== */
	if ( is_active_sidebar( 'sidebar-1' )  ) :
?>
	<aside id="sidebar"><?php dynamic_sidebar( 'sidebar-1' ); ?></aside>
<?php
	endif;
?>