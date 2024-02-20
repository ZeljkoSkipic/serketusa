<?php
/* Email template Customer Account Approved */
$username = isset($args['username']) ? $args['username'] : "";
?>
<p><?php printf(__('Hello %s, ', 'register'), $username); ?></p>
<p style="margin: 0 0 16px;">
	<?php the_field('customer_approved', 'option'); ?>
    <?php printf(__('Your username is <strong>%s</strong>. You can access your account area to view orders, change your password, and more at:', 'register'), $username) ?>
    <a href="<?php echo get_permalink(wc_get_page_id('myaccount')); ?>" style="font-weight: normal; text-decoration: underline;" target="_blank"><?php echo get_permalink(wc_get_page_id('myaccount')); ?></a>
</p>
<p><?php _e('We look forward to seeing you soon.', 'register') ?></p>
