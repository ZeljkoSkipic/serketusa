<?php
	$s_tier_comment_count = get_comments_number();
	if ( '1' === $s_tier_comment_count ) {
		printf(
			esc_html__( '1 Comment', 's-tier' )
		);
	} else if ( '0' === $s_tier_comment_count ) {
		printf(
			esc_html__( 'No Comments', 's-tier' )
		);
	} else {
		printf(
			/* translators: 1: comment count number, 2: title. */
			esc_html( _nx( '%1$s Comments', '%1$s Comments', $s_tier_comment_count, 'comments title', 's-tier' ) ),
			number_format_i18n( $s_tier_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}
?>
