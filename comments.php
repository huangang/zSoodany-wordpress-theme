<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'zSoodany' ),
					number_format_i18n( get_comments_number() ), get_the_title() );
			?>
		</h2>
		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 34,
				) );
			?>
		</ol><!-- .comment-list -->

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'zSoodany' ); ?></p>
	<?php endif; ?>
	<section id="contact-form">
	<?php comments_form(); ?>
	<script type="text/javascript">
	$("#author").focus(function(){if(this.value =='Author' ) this.value=''});
	$("#author").blur(function(){if(this.value=='') this.value='Author'});
	$("#email").focus(function(){if(this.value =='Email' ) this.value=''});
	$("#email").blur(function(){if(this.value=='') this.value='Email'});
	$("#url").focus(function(){if(this.value =='Url' ) this.value=''});
	$("#url").blur(function(){if(this.value=='') this.value='Url'});
	$("#submit").addClass("buttons");
	</script>
	</section>
</div><!-- .comments-area -->
