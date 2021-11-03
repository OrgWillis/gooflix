<?php 
// Options
$icon = compose_image_option('favicon');
$logo = compose_image_option('headlogo');
$logo = ($logo) ? $logo : return_assets_image('logo.png');
$icon = ($icon) ? $icon : return_assets_image('favicon.png');

?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<link rel="icon" href="<?php echo $icon; ?>" type="image/x-icon" />
	<style type="text/css">
		:root {
			--darkbg: <?php echo cs_get_option('bgcolor', '#000000'); ?>;
			--orange: <?php echo cs_get_option('maincolor','#FF4900'); ?>;
		}
	</style>
	<?php wp_head(); ?>
</head>
<body id="index">

	<header id="topBar">
		<div class="wrap">
			<a title="Início" href="<?php echo URL; ?>" class="logo">
				<img src="<?php echo $logo; ?>" alt="">
			</a>
			<div class="openTopBar"><div class="bar"></div><div class="bar"></div><div class="bar"></div></div>
			
			<?php get_search_form(); ?>

			<div class="menu">

				<a title="Início" class="hover item <?php if ( is_home() ) echo 'active'; ?>" href="<?php echo esc_url(home_url()); ?>">
					<?php _e( 'Home', 'mega' ); ?>
				</a>

				<a href="<?php echo home_url().'/movies'.get_option('movies_slug'); ?>" class="hover item <?php ActiveClass('movies'); ?>">
					<?php _e( 'Filmes', 'mega' ); ?>
				</a>
				
				<a href="<?php echo home_url().'/tvshows'.get_option('tvshows_slug'); ?>" class="hover item <?php ActiveClass('tvshows'); ?>">
					<?php _e( 'Séries', 'mega' ); ?>
				</a>

				<?php

				$menuParameters = array(
					'theme_location' => 'header',
					'container'       => false,
					'echo'            => false,
					'items_wrap'      => '%3$s',
					'depth'           => 1,
					'walker'         => new walker_header(),
					'fallback_cb'    => '',
				);

				echo strip_tags(wp_nav_menu($menuParameters), '<a>' );

				?> 
			</div>
		</div>
	</header>