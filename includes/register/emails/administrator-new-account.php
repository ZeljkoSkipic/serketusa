<?php
/* Email template Customer Admin Account */

$username = isset($args['username']) ? $args['username'] : "";
$email = isset($args['email']) ? $args['email'] : "";
?>
<div style="margin: 0 0 16px;">
    <?php the_field('admin_notification', 'option') ?>
</div>
<p><?php echo __('Username: ', 'register'). $username;?></p>
<p><?php echo __('Email: ', 'register'). $email; ?></p>
