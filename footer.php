<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package s-tier
 */

$email = get_field('email', 'option');

?>

	<footer id="colophon" class="site-footer space_4_0">
		<div class="footer_inner c-wide">
			<div class="col"> <!-- Logo and Info -->
				<?php
				$image = get_field('image', 'option');
				$size = 'full';
				if( $image ) { ?>
					<a href="/">
					<?php echo wp_get_attachment_image( $image, $size, "", array( "class" => "image" ) ); ?>
					</a>
				<?php } ?>
				<p class="location"><?php the_field('location', 'option'); ?></p>
				<a href="<?php echo esc_url( 'mailto:' . antispambot( $email ) ); ?>" class="email"><?php echo esc_html( antispambot( $email ) ); ?></a>
				<div class="socials">
					<a href="<?php the_field('facebook', 'option'); ?>" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" width="17.922" height="33.502" viewBox="0 0 17.922 33.502">
							<path id="Path_23" data-name="Path 23" d="M5.458,33.5h6.49V18.529h4.794l.959-6.048H11.948V7.908c0-1.7,1.623-2.655,3.172-2.655h2.8V.238L12.907.017c-4.794-.3-7.449,3.466-7.449,7.966v4.5H0v6.048H5.458Z" fill="#ecaa1f" fill-rule="evenodd"/>
						</svg>
					</a>
					<a href="<?php the_field('instagram', 'option'); ?>" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" width="30.383" height="30.311" viewBox="0 0 30.383 30.311">
							<path id="Path_24" data-name="Path 24" d="M606.251,3.723h13.995a8.232,8.232,0,0,1,8.194,8.194V25.84a8.232,8.232,0,0,1-8.194,8.194H606.251a8.232,8.232,0,0,1-8.194-8.194V11.917a8.232,8.232,0,0,1,8.194-8.194m15.155,5.294h0a1.74,1.74,0,1,1,0,3.481,1.74,1.74,0,0,1,0-3.481m-8.194,1.6h.072a8.267,8.267,0,0,1,0,16.533h-.072a8.267,8.267,0,0,1,0-16.533m0,2.828h.072a5.475,5.475,0,0,1,0,10.95h-.072a5.475,5.475,0,0,1,0-10.95m-6.889-7.106h13.85a5.663,5.663,0,0,1,5.656,5.656V25.767a5.663,5.663,0,0,1-5.656,5.656h-13.85a5.663,5.663,0,0,1-5.656-5.656V11.989a5.663,5.663,0,0,1,5.656-5.656" transform="translate(-598.057 -3.723)" fill="#ecaa1f" fill-rule="evenodd"/>
						</svg>
					</a>
					<a href="<?php the_field('linkedin', 'option'); ?>" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" width="26.987" height="27.12" viewBox="0 0 26.987 27.12">
							<path id="Path_25" data-name="Path 25" d="M1908.333,628.635h5.358v17.992h-5.358Zm2.646-9.128a3.241,3.241,0,1,1,0,6.482,3.242,3.242,0,0,1,0-6.482m5.887,9.128h5.292v2.513a6.123,6.123,0,0,1,5.093-2.712h1.455a6.112,6.112,0,0,1,6.085,6.086v12.1H1929.5V636.9a3.518,3.518,0,0,0-3.506-3.638,3.8,3.8,0,0,0-3.836,3.638v9.724h-5.292Z" transform="translate(-1907.804 -619.507)" fill="#ecaa1f" fill-rule="evenodd"/>
						</svg>
					</a>
					<a href="<?php the_field('twitter', 'option'); ?>" target="_blank">
					<svg width="1200" height="1227" viewBox="0 0 1200 1227" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M714.163 519.284L1160.89 0H1055.03L667.137 450.887L357.328 0H0L468.492 681.821L0 1226.37H105.866L515.491 750.218L842.672 1226.37H1200L714.137 519.284H714.163ZM569.165 687.828L521.697 619.934L144.011 79.6944H306.615L611.412 515.685L658.88 583.579L1055.08 1150.3H892.476L569.165 687.854V687.828Z" fill="white"/>
					</svg>
					</a>
				</div>
			</div>

			<div class="col"> <!-- Apparel Menu -->
				<h4><?php the_field('col_2_menu_title', 'option'); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'apparel',
						'menu_id'        => 'apparel-menu',
					)
				);
				?>
			</div>

			<div class="col"> <!-- Equipment Menu -->
				<h4><?php the_field('col_3_menu_title', 'option'); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'equipment',
						'menu_id'        => 'equipment-menu',
					)
				);
				?>
			</div>

			<div class="col"> <!-- About Menu -->
				<h4><?php the_field('col_4_menu_title', 'option'); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'about',
						'menu_id'        => 'about-menu',
					)
				);
				?>
			</div>
			<div class="col"> <!-- Contact Menu -->

			</div>

			<div class="col"> <!-- Newsletter -->
				<div id="mc_embed_shell">
					<div id="mc_embed_signup">
						<form action="https://westernshelter.us12.list-manage.com/subscribe/post?u=46691f85844d13219c6c4de0a&amp;id=0143e9f533&amp;f_id=00580de1f0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_self" novalidate="">
							<div id="mc_embed_signup_scroll"><h2>Sign Up</h2>
								<p>Receive special alerts and discounts when you subscribe to the Serket Newsletter.</p>
								<div class="mc-field-group"><input type="email" name="EMAIL" class="required email" id="mce-EMAIL" required="" value="" placeholder="Enter email address"></div>
							<div id="mce-responses" class="clear">
								<div class="response" id="mce-error-response" style="display: none;"></div>
								<div class="response" id="mce-success-response" style="display: none;"></div>
							</div><div aria-hidden="true" style="position: absolute; left: -5000px;"><input type="text" name="b_46691f85844d13219c6c4de0a_0143e9f533" tabindex="-1" value=""></div><div class="clear"><input type="submit" name="subscribe" id="mc-embedded-subscribe" class="button" value="Subscribe"></div>
						</div>
					</form>
					</div>
				</div>


			</div>
		</div>

		<div class="footer_bottom c-wide">
			<p><?php echo wp_kses_post( get_field('copy', 'option') ); ?></p>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
<!--
	         (__)
     `\------(oo)
       ||    (__) <(What are you looking for?)
       ||w--||
-->
<?php the_field('body_bottom_script', 'option'); ?> <!-- Body Bottom External Code -->
</body>
</html>
