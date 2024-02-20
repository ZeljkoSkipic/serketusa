<?php
/* Email template Customer New Account */

$username = isset($args['username']) ? $args['username'] : "";
?>
<p><?php printf(__('Hello %s, ', 'register'), $username); ?></p>
<div style="margin: 0 0 16px;">
    <?php the_field('customer_notification', 'option'); ?>
</div>
