<footer>
	<div class="wrap">
		<div class="footerLinks">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => '',
					'depth'          => '1',
					'fallback_cb'    => '',
				)
			);
			?>
		</div>
		<?php if (cs_get_option('social')) {?>
			<h2>SIGA-NOS NAS REDES</h2>
			<div class="social">
				<?php if ($url = cs_get_option('url_facebook')) {?>
					<a href="<?php echo $url; ?>" target="_BLANK">
						<img src="<?php assets_image('facebook.png'); ?>" alt="Facebook">
					</a>
				<?php } if ($url = cs_get_option('url_instagram')) {?>
					<a href="<?php echo $url; ?>" target="_BLANK">
						<img src="<?php assets_image('instagram.png'); ?>" alt="Instagram">
					</a>
				<?php } ?>
			</div>
		<?php } ?>
		<div class="copyright">
			<?php _e('© Copyright All rights reserved','mega'); ?> 
			<span><?php echo THEME_NAME; ?></span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
