<?php 

/*

Template Name: Page App

*/
get_header();?>

<main class="wrap" id="appPage">
	<div class="firstText">
		<h1><?php echo THEME_NAME; ?> BETA <span><?php echo cs_get_option('version_app', '1.0'); ?></span></h1>
		<h2>O APLICATIVO DE FILMES E SÉRIES ONLINE GRÁTIS <br> ESTÁ DE CARA NOVA!</h2>

		<a href="<?php echo cs_get_option('update_url'); ?>" download="" target="_BLANK" class="downBtn downloadDireto">
			<i>
				<?php get_template_part('assets/img/icone/app'); ?>
			</i>
			<span>Baixar APK</span>
		</a>
		<div class="functions">
			<div class="item">
				<i>
					<?php get_template_part('assets/img/icone/play'); ?>
				</i>
				<div class="text">Play Próprio</div>
			</div>
			<div class="item">
				<i>
					<?php get_template_part('assets/img/icone/download'); ?>
				</i>
				<div class="text">Downloads</div>
			</div>
			<div class="item">
				<i>
					<?php get_template_part('assets/img/icone/chromecast'); ?>
				</i>
				<div class="text">Chromecast</div>
			</div>
			<div class="item">
				<i>
					<?php get_template_part('assets/img/icone/phone'); ?>
				</i>
				<div class="text">Notificações</div>
			</div>
		</div>
	</div>
</main>
<?php
get_footer();