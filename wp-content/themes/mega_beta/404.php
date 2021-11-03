<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
	<style>
		body, html{
			background: #FFF;
			padding: 0;
			margin:0;
			display: block;
			font-family: 'Open Sans', sans-serif;
		}
		.errorPage50x{
			display: block;
			width: 100%;
			margin-top: 100px;
			margin-bottom: 100px;
			text-align: center;
		}

		a{
			width: 200px;
			height: 50px;
			border-radius: 5px;
			background:#FF4900;
			display: block;
			margin:0px auto;
			font-size: 14px;
			font-weight: 300;
			color: #FFF;
			line-height: 50px;
			cursor: pointer;
			text-decoration: none;
			transition: all .1s ease-in-out;
		}
	</style>
</head>
<body>
	<div class="errorPage50x">
		<img src="<?php assets_image('404.png'); ?>" width="500" height="408" alt="Erro no Mega">
		<a href="<?php echo esc_url(home_url()); ?>"><?php _e('GO BACK TO EARTH!','mega'); ?></a>
	</div>
	<?php wp_footer(); ?>
</body>
</html>

