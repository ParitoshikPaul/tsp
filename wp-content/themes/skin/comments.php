<?php
/* ==============================================
	COMMENTS TEMPLATE
	Skin - Premium WordPress Theme, by NordWood
================================================= */
	if ( post_password_required() ) {
		return;
	}
?>
<div id="comments" class="wp-comments">
	<header class="comments-header content-pad"><?php
		if ( ! comments_open() ) {
			printf(
				'<h5>%s</h5>',
				esc_html__( 'Comments are closed.', 'skin' )
			);
			
		} else {
	?>
		<table>
			<tr>
				<td><?php
					$qty = get_comments_number();
					
					if ( ! $qty ) {
						printf(
							'<h5>%s</h5>',
							esc_html__( 'No comments yet. Be the first one to leave a thought.', 'skin' )
						);
						
					} else {
						printf(
							'<h3 class="txt-color-to-svg">%1$s %2$s %3$s</h3>',
							skin_get_icon_comment(),
							esc_html( number_format_i18n( $qty ) ),
							esc_html( _n( 'comment', 'comments', $qty, 'skin' ) )
						);
					}
				?></td>
				
				<td>
					<a href="#respond" class="leave-comment smooth-scroll link-button skin-outlined-bttn skin-anim-bttn"><?php esc_html_e( 'Leave a comment', 'skin' ) ?></a>
				</td>
			</tr>
		</table>
	<?php
		}
	?></header>
	
<?php
	if ( have_comments() ) :
?>
	<ol class="comments-list"><?php
		wp_list_comments( array(
			'short_ping'  	=> true,
			'avatar_size' 	=> 50,
			'max_depth'		=> 2,
			'style'			=> 'ul',
			'callback'		=> 'skin_comments_list'
		));
	?></ol>
	
	<div class="comments-nav txt-color-to-svg clearfix"><?php
		$comments_nav_args = array(
			'prev_text'	=> skin_get_elastic_arrow_left(),
			'next_text'	=> skin_get_elastic_arrow_right(),
			'type'		=> 'plain'
		);
		
		paginate_comments_links( $comments_nav_args );
	?></div>
<?php
	endif;
	
	$comment_form_args = array(
		'title_reply'			=> sprintf( '%1$s %2$s', skin_get_icon_comment(), esc_html__( 'Leave a Comment','skin' ) ),
		'title_reply_before'	=> '<h3 class="comment-reply-title txt-color-to-svg">',
		'title_reply_after'		=> '</h3>',
		'title_reply_to' 		=> sprintf( '<span>%s</span>', esc_html__( 'Reply','skin' ) ),
		'cancel_reply_link' 	=> sprintf( '<span>%s</span>', esc_html__( 'Cancel','skin' ) ),
		'label_submit' 			=> esc_html__( 'Send comment','skin' ),
		'class_submit' 			=> 'submit-comment txt-color-light-to-border',
		'fields' 				=> apply_filters(
			'comment_form_default_fields', array(
				'author' =>'<input type="text"
								class="txt-color-light-to-border"
								name="author"
								placeholder="' . esc_attr__( 'Your name', 'skin' ) . '"
								value="' . esc_attr( $commenter['comment_author'] ) . '"
							>',
				'email'  => '<input type="email"
								class="txt-color-light-to-border"
								name="email"
								placeholder="' . esc_attr__( 'Your E-mail address', 'skin' ) . '"
								value="' . esc_attr(  $commenter['comment_author_email'] ) . '"
							>',
				'url'    => '<input type="url"
								class="txt-color-light-to-border"
								name="url"
								placeholder="' . esc_attr__( 'Your website', 'skin' ) . '"
								value="' . esc_attr( $commenter['comment_author_url'] ) . '"
							>'
			)
		),
		'comment_field'			=> '<textarea id="comment"
										class="txt-color-light-to-border"
										name="comment"
										placeholder="' . esc_attr__( 'Enter your comment here', 'skin' ) . '"
										rows="4"
										required="required"></textarea>',
		'comment_notes_before'	=> '',
		'comment_notes_after'	=> '',
		'class_form'			=> 'comment-form clearfix'
	);

	comment_form( $comment_form_args );	
?>
</div>