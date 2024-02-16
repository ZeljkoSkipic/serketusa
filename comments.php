<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package s-tier
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php function st_comments( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-left">
				<?php echo get_avatar( $comment, $size='118' ); ?>
			</div>
			<div class="comment-right">
				<div class="comment-right-top">
                	<?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
					<div class="comment-meta commentmetadata">
						<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
						<?php printf( __( '%1$s at %2$s' ), get_comment_date(),  get_comment_time() ); ?></a>
						<?php edit_comment_link( __( '(Edit)' ),'  ','' ); ?>
					</div>
					<div class="reply">
					<?php
                	comment_reply_link( array_merge( $args, array(
						'add_below' => 'comment', // The element to append the reply link to
						'depth'     => $depth,
						'max_depth' => $args['max_depth']
					)));
                ?>
					</div>
				</div>
				<div class="comment-right-bottom">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
				<?php endif; ?>
				<?php comment_text(); ?>
				</div>
			</div>
        </div>
<?php
} ?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php get_template_part( 'template-parts/comment', 'count' ); ?>
		</h2><!-- .comments-title -->
		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'callback' => 'st_comments'
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 's-tier' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form();
	?>

</div><!-- #comments -->
