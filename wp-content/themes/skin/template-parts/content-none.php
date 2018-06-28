<?php
/* ==============================================
	NO CONTENT template part
	Skin - Premium WordPress Theme, by NordWood
================================================= */
?>
	<div class="archive-header">
		<div class="content-wrapper"><?php
			if ( is_home() && current_user_can( 'publish_posts' ) ) {
		?>
			<table>
				<tr>
					<td class="content-pad va-middle">
						<a class="add" href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>"><div class="rounded-button-outline round">
							<div class="outline-pale txt-color-pale-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
							<div class="outline-full txt-color-to-svg"><?php echo skin_draw_circle( 25, 25, 25, 3 ); ?></div>
							<div class="icon txt-color-to-svg"><?php echo skin_get_icon_plus(); ?></div>
						</div></a>
					</td>
					
					<td>
						<div class="content-pad">
							<h1><?php esc_html_e( 'Ready to publish your first post?', 'skin' ); ?></h1>
						</div>
					</td>
				</tr>
			</table>
		<?php
			} else if ( is_search() ) {
		?>
			<table>
				<tr>
					<td class="content-pad"><span class="bummer txt-color-to-svg"><?php echo skin_get_icon_bummer(); ?></span></td>
					
					<td>
						<div class="content-pad"><?php get_search_form(); ?></div>
					</td>
				</tr>
			</table>
			
			<div class="archive-desc content-pad"><?php esc_html_e( 'Sorry, no results are returned. Try with another search?', 'skin' ); ?></div>
		<?php
			} else {
		?>
			<table>
				<tr>
					<td class="content-pad"><span class="bummer txt-color-to-svg"><?php echo skin_get_icon_bummer(); ?></span></td>
					
					<td>
						<div class="content-pad"><?php get_search_form(); ?></div>
					</td>
				</tr>
			</table>
			
			<div class="archive-desc content-pad"><?php esc_html_e( 'Sorry, no results are returned. Try with a search, perhaps?', 'skin' ); ?></div>
		<?php
			}
		?></div>
	</div>